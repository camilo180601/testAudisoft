<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreSiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normaliza la URL antes de validar: si no trae esquema, antepone https://
     */
    protected function prepareForValidation(): void
    {
        $url = trim((string) $this->input('url'));

        if ($url !== '' && ! Str::startsWith($url, ['http://', 'https://'])) {
            $url = 'https://'.$url;
        }

        $this->merge([
            'name' => trim((string) $this->input('name')),
            'url' => $url,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:2048', 'url:http,https'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'url' => 'dirección',
            'category_id' => 'categoría',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'url.url' => 'La dirección debe ser un enlace web válido (http o https).',
            'category_id.required' => 'Debe seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }
}
