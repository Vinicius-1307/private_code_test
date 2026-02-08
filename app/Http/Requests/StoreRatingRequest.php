<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
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
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'score.required' => 'A avaliação é obrigatória.',
            'score.integer' => 'A avaliação deve ser um número.',
            'score.min' => 'A avaliação mínima é 1.',
            'score.max' => 'A avaliação máxima é 5.',
        ];
    }
}
