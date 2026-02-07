<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:120'],
            'description' => ['nullable', 'string'],
            'ingredients' => ['required', 'array'],
            'ingredients.*' => ['required', 'string'],
            'steps' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O título da receita é obrigatório.',
            'title.min' => 'O título deve ter no mínimo 3 caracteres.',
            'title.max' => 'O título deve ter no máximo 120 caracteres.',
            'ingredients.required' => 'Os ingredientes são obrigatórios.',
            'ingredients.array' => 'Os ingredientes devem ser fornecidos em formato de lista.',
            'ingredients.*.required' => 'Cada ingrediente deve ser preenchido.',
            'steps.required' => 'O modo de preparo é obrigatório.',
        ];
    }
}
