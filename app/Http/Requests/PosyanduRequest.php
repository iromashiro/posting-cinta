<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PosyanduRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('posyandu');
        if (is_object($id) && method_exists($id, 'getKey')) {
            $id = $id->getKey();
        }

        return [
            'puskesmas_id' => ['required', 'exists:puskesmas,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posyandu', 'name')
                    ->where(fn($q) => $q->where('puskesmas_id', $this->input('puskesmas_id')))
                    ->ignore($id),
            ],
            'village' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'kader_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'puskesmas_id.required' => 'Puskesmas wajib dipilih.',
            'name.required' => 'Nama posyandu wajib diisi.',
            'name.unique' => 'Nama posyandu sudah digunakan pada puskesmas tersebut.',
        ];
    }
}
