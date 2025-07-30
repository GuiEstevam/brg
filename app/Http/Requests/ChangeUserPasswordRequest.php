<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeUserPasswordRequest extends FormRequest
{
    /**
     * Verifica se o usuário está autorizado a realizar esta requisição.
     */
    public function authorize(): bool
    {
        // Aqui você pode personalizar conforme sua política de acesso.
        // Exemplo: apenas admins/masters podem alterar senha de outros.
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'master']);
    }

    /**
     * Regras de validação para alteração de senha.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Mensagens de validação customizadas.
     */
    public function messages(): array
    {
        return [
            'new_password.required' => 'Informe a nova senha.',
            'new_password.min'      => 'A nova senha deve ter pelo menos 8 caracteres.',
            'new_password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }

    /**
     * Altera o nome do campo para exibir corretamente os erros de confirmação.
     */
    public function attributes(): array
    {
        return [
            'new_password' => 'nova senha',
            'new_password_confirmation' => 'confirmação da nova senha',
        ];
    }
}
