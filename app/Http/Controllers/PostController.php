<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    // middleware sanctum pour exiger une preuve de connexion : soit le token, soit les cookies csrf + de session
    // appliqué sur toutes les routes sauf index (pas besoin d'être connecté pour voir les messages sur l'accueil
    // ou pour consulter un message en particulier)
    public function __construct()
    {
        //$this->middleware('auth:sanctum')->except('index', 'show');
        $this->middleware('auth:sanctum'); // pour tester sanctum sur la liste des posts
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les posts (le + récent en 1er)
        $posts = Post::latest()->get();

        // on charge leurs auteurs et leurs commentaires (avec auteurs)
        // => commenté car déjà chargé via $with dans les modèles Post et Comment 
        //$posts->load('user', 'comments.user');

        // On retourne les posts en JSON 
        return response()->json([
            'status' => true,
            'message' => 'Posts récupérés avec succès',
            'posts' => $posts
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // sauvegarde du post en bdd
        $post = Post::create($request->all());

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $post->update(['image' => $imageName]);
        }

        // on retourne le post créé en json avec un code de succès (201)
        return response()->json([
            'status' => true,
            'message' => 'Post créé avec succès',
            'post' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // on retourne le post en json 
        return response()->json([
            'status' => true,
            'message' => 'Post récupéré avec succès',
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // policy pour vérifier que l'utilisateur peut modifier le post
        $this->authorize('update', $post);

        // modification post en bdd
        $post->update($request->except('image'));

        // sauvegarde de l'image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            // on supprime l'ancienne image si existante
            $imagePath = 'images/' . $post->image;

            if (File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }

            $post->update(['image' => $imageName]);
        }

        // On retourne la réponse JSON
        return response()->json([
            'status' => true,
            'message' => 'Post modifié avec succès',
            'post' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // policy pour vérifier que l'utilisateur peut supprimer le post
        $this->authorize('delete', $post);

        $post->delete(); // suppression post via syntaxe Eloquent

        // on supprime son image si existante (plus besoin)
        $imagePath = 'images/' . $post->image;

        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }

        return response()->json([
            'status' => true,
            'message' => 'Post supprimé',
            'post' => $post
        ]);
    }
}
