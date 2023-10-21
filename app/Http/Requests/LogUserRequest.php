<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LogUserRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'message' => 'Erreur de validation',
            'errorListe' => $validator->errors()
        ], 422)); // Utilisation du code de statut HTTP 422 pour indiquer une erreur de validation non traitée.
    }

    public function messages()
    {
        return [
            'email.required' => 'L\'adresse e-mail est requise',
            'email.email' => 'L\'adresse e-mail doit être une adresse e-mail valide',
            'email.exists' => 'L\'adresse e-mail n\'existe pas dans notre système',
            'password.required' => 'Le mot de passe est requis'
        ];
    }
}
