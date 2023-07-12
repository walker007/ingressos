<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIngressoRequest extends FormRequest
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
            "evento_id"              => "integer|required|exists:eventos,id",
            "lote"                   => "string|required",
            "inicio"                 => "date|required_without:quantidade_disponivel",
            "fim"                    => "date|required_without:quantidade_disponivel",
            "quantidade_disponivel"  => "integer|required_without_all:inicio,fim",
            "preco"                  => "decimal:1,2|required"
        ];
    }
}
