<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    // middleware sanctum pour exiger une preuve de connexion : soit le token, soit les cookies csrf + de session
    // appliqué sur toutes les routes sauf store (pas besoin d'être connecté pour créer un utilisateur)
    // middleware admin appliqué sur route index (liste des utilisateurs)
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('store');
        $this->middleware('admin')->only('index');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $users = User::all();

        // on applique la vérification de la fonction viewAny de la UserPolicy
        // => seul l'admin peut accéder à la liste des messages
        // => résultat identique à l'application du middleware "admin"
        //$this->authorize('viewAny', $users); 

        // On retourne les utilisateurs en JSON 
        return response()->json([
            'status' => true,
            'message' => 'Utilisateurs récupérés avec succès',
            'users' => $users
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // sauvegarde utilisateur en bdd
        $user = User::create([
            'pseudo' => $request->pseudo,
            'image' => $request->image,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');   // on récupère l'image transmise
            $imageName = time() . '.' . $image->extension();  // on lui donne un nom
            $image->move(public_path('images'), $imageName); // on la déplace dans le dossier public/images
            $user->update(['image' => $imageName]); // on met à jour l'utilisateur
        }

        // on retourne l'utilisateur créé en json avec un code de succès (201 = création réussie)
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // application méthode view de la UserPolicy => seul le user peut voir son profil (ou l'admin)
        $this->authorize('view', $user);

        // on retourne l'utilisateur en json 
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur récupéré avec succès',
            'user' => $user->load('posts')  // on charge ses posts (pour les afficher sur son profil)
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // policy pour vérifier que l'utilisateur peut modifier le compte
        // critère : il ne peut modifier que son propre compte 
        $this->authorize('update', $user);

        // On modifie les informations de l'utilisateur

        // email (si fourni)
        if ($request->email) {
            $user->update([
                'email' => $request->email
            ]);
        }

        // sauvegarde de la nouvelle image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            $imagePath = 'images/' . $user->image;      // on supprime l'ancienne image (si existante)
            if (File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }

            $user->update(['image' => $imageName]);
        }

        // si nouveau mdp choisi (et qui respecte bien sûr les critères de sécurité du validateur)
        if ($request->password) {

            // si ancien mdp fourni ET valide (vérifié via Hash::check), modification validée 
            if ($request->oldPassword && Hash::check($request->oldPassword, User::find($user->id)->password)) {
                // on sauvegarde le nouveau mot de passe hashé
                $user->update([
                    'password' => Hash::make($request->password)
                ]);

                // sinon => on renvoie une erreur
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'mot de passe actuel non renseigné ou incorrect',
                    'user' => $user
                ], 400);
            }
        }

        // On retourne la réponse JSON
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur modifié avec succès',
            'user' => $user
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // policy pour vérifier que l'utilisateur est autorisé à supprimer le compte
        // critère : seul l'utilisateur peut supprimer son compte (ou l'admin)
        $this->authorize('delete', $user);

        // on supprime l'utilisateur en base de données
        $user->delete();

        // on supprime son image de profil (plus besoin)
        $imagePath = 'images/' . $user->image;

        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }

        // on retourne la réponse contenant l'utilisateur supprimé
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur supprimé',
            'user' => $user
        ]);
    }
}
