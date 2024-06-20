<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'content' => 'required|min:15|max:3000',
            'tags' => 'required|min:5|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'user_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            //critères contenu
            'content.required' => 'Le contenu est requis.',
            'content.string' => 'Le contenu doit être une chaîne de caractères.',
            'content.min' => 'Le contenu doit faire au moins 15 caractères.',
            'content.max' => 'Le contenu ne doit pas dépasser 3000 caractères.',
            //critères tags
            'tags.required' => 'Les tags sont requis.',
            'tags.string' => 'Les tags doivent être une chaîne de caractères.',
            'tags.min' => 'Les tags doivent faire au moins 5 caractères.',
            'tags.max' => 'Les tags ne doivent pas dépasser 50 caractères.',
            //critères image
            'image.image' => 'L\'image doit être un fichier de type image.',
            'image.mimes' => 'L\'image doit être un fichier de type jpg, jpeg, png ou svg.',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
            'user_id.required' => 'Le user_id est requis.',
            'user_id.integer' => 'Le user_id doit être un nombre.',
        ];
    }
}
