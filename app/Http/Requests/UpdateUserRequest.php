<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'nullable|email|max:50',
            'oldPassword' => 'nullable',
            'password' => [
                'nullable', 'confirmed',
                Password::min(8) // minimum 8 caractères   
                    ->mixedCase() // au moins 1 minuscule et une majuscule
                    ->letters()  // au moins une lettre
                    ->numbers() // au moins un chiffre
                    ->symbols() // au moins un caractère spécial     
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'pseudo.required' => 'Le pseudo est requis.',
            'pseudo.string' => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.min' => 'Le pseudo doit faire au moins 4 caractères.',
            'pseudo.max' => 'Le pseudo ne doit pas dépasser 25 caractères.',
            'email.unique' => 'Pseudo déjà utilisé.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'Email invalide.',
            'pseudo.min' => 'L\'email doit faire au moins 7 caractères.',
            'pseudo.max' => 'L\'email ne doit pas dépasser 50 caractères.',
            'email.unique' => 'Email déjà utilisé.',
            'password.required' => 'Le mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
            'password.confirmed' => 'Confirmation du mot de passe incorrecte.',
            'image.max' => 'Votre image est trop lourde : elle doit faire moins de 2 Mo.'
        ];
    }
}
