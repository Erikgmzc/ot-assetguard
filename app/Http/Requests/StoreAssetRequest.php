<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'type' => ['required', 'string', 'max:60'],
            'ip_address' => ['required', 'ipv4', 'unique:assets,ip_address'],
            'location' => ['required', 'string', 'max:150'],
            'firmware_version' => ['nullable', 'string', 'max:60'],
            'status' => ['required', Rule::in(['operativo', 'mantenimiento', 'critico', 'baja'])],
        ];
    }
}