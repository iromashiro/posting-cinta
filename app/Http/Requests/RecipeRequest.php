<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya admin dan puskesmas yang bisa create/edit resep
        return in_array(auth()->user()->role, ['admin', 'puskesmas']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'age_category' => ['required', 'in:mpasi_6_12,balita_1_3,anak_3_5'],
            'image' => ['nullable', 'image', 'max:2048'], // max 2MB
            'image_url' => ['nullable', 'string', 'max:500'],
            'ingredients' => ['required', 'string'],
            'instructions' => ['required', 'string'],
            'calories' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'protein' => ['nullable', 'integer', 'min:0', 'max:999'],
            'carbohydrate' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul resep wajib diisi.',
            'title.max' => 'Judul resep maksimal 255 karakter.',
            'age_category.required' => 'Kategori usia wajib dipilih.',
            'age_category.in' => 'Kategori usia tidak valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'ingredients.required' => 'Bahan-bahan wajib diisi.',
            'instructions.required' => 'Cara memasak wajib diisi.',
            'calories.integer' => 'Kalori harus berupa angka.',
            'calories.min' => 'Kalori tidak boleh negatif.',
            'protein.integer' => 'Protein harus berupa angka.',
            'protein.min' => 'Protein tidak boleh negatif.',
            'carbohydrate.integer' => 'Karbohidrat harus berupa angka.',
            'carbohydrate.min' => 'Karbohidrat tidak boleh negatif.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul',
            'age_category' => 'kategori usia',
            'image' => 'gambar',
            'ingredients' => 'bahan-bahan',
            'instructions' => 'cara memasak',
            'calories' => 'kalori',
            'protein' => 'protein',
            'carbohydrate' => 'karbohidrat',
        ];
    }
}
