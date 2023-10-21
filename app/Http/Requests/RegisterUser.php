<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUser extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'passeword'=>'required'
        ];
    }

    public function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status_code' => 422,
            'error' => true,
            'message'=>'Erreur de validation',
            'errorListe' => $validator->errors()
        ], 422)); // Utilisation du code de statut HTTP 422 pour indiquer une erreur de validation non traitée.
    }

    public function messages()
    {
        return [
            'name.required' => 'Un nom doit etre fourni',
            'email.required' => 'Le champ "email" est obligatoire',
            'email.email' => 'L\'adresse e-mail doit être valide',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée par un autre utilisateur',
            // Ajoutez d'autres messages d'erreur personnalisés ici
        ];
    }
}
