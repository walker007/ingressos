<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EventosRequest extends FormRequest
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
            "nome" => "string|required",
            "descricao" => "string|nullable",
            "local" => "string|nullable",
            "data_evento" => "date|required|after:" . Carbon::now("America/Sao_Paulo")->format("Y-m-d H:i:s"),
            "user_id" => "integer|required|exists:users,id",
            "slug" => "string|unique:eventos,slug,{$this->id},id"
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            "slug" => $this->slug ? $this->slug : Str::slug($this->nome),
        ]);
    }


    public function messages(): array
    {
        return [
            "user_id.required" => "Informe o usuário",
            "user_id.integer" => "Informe um usuário",
            "user_id.exists" => "O usuário informado não existe"
        ];
    }
}
