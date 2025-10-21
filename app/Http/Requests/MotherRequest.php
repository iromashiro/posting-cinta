<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MotherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('mother');
        if (is_object($id) && method_exists($id, 'getKey')) {
            $id = $id->getKey();
        }

        return [
            'posyandu_id' => ['required', 'exists:posyandu,id'],
            'name' => ['required', 'string', 'max:255'],
            'nik' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('mothers', 'nik')->ignore($id),
            ],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'posyandu_id.required' => 'Posyandu wajib dipilih.',
            'posyandu_id.exists' => 'Posyandu tidak valid.',
            'name.required' => 'Nama ibu wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
        ];
    }
}
