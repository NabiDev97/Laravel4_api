<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditPostRequest extends FormRequest
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
            'titre' => 'required'
        ];
    }

    public function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'message' => 'Erreur de validation',
            'errorListe' => $validator->errors()
        ], 422)); // On utilise ici le code de statut HTTP 422 pour indiquer une erreur de validation non traitée.
    }

    public function messages()
    {
        return [
            'titre.required' => 'Un titre doit être fourni'
        ];
    }
}
