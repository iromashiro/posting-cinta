<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChildRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('child');
        if (is_object($id) && method_exists($id, 'getKey')) {
            $id = $id->getKey();
        }

        return [
            'mother_id' => ['required', 'exists:mothers,id'],
            'posyandu_id' => ['required', 'exists:posyandu,id'],
            'name' => ['required', 'string', 'max:255'],
            'nik' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('children', 'nik')->ignore($id),
            ],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'date_of_birth' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'mother_id.required' => 'Ibu wajib dipilih.',
            'mother_id.exists' => 'Ibu tidak valid.',
            'posyandu_id.required' => 'Posyandu wajib dipilih.',
            'posyandu_id.exists' => 'Posyandu tidak valid.',
            'name.required' => 'Nama anak wajib diisi.',
            'nik.unique' => 'NIK anak sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid.',
        ];
    }
}
