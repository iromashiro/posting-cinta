<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeasurementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'child_id' => ['required', 'exists:children,id'],
            'measured_at' => ['required', 'date'],
            'weight' => ['required', 'numeric', 'min:0.5', 'max:60'], // kg
            'height' => ['required', 'numeric', 'min:25', 'max:130'], // cm
            'head_circumference' => ['nullable', 'numeric', 'min:20', 'max:60'], // cm
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'child_id.required' => 'Anak wajib dipilih.',
            'child_id.exists' => 'Data anak tidak valid.',
            'measured_at.required' => 'Tanggal ukur wajib diisi.',
            'measured_at.date' => 'Format tanggal ukur tidak valid.',
            'weight.required' => 'Berat badan wajib diisi.',
            'weight.numeric' => 'Berat badan harus angka.',
            'height.required' => 'Tinggi/Panjang badan wajib diisi.',
            'height.numeric' => 'Tinggi/Panjang badan harus angka.',
            'head_circumference.numeric' => 'LK harus angka.',
        ];
    }
}
