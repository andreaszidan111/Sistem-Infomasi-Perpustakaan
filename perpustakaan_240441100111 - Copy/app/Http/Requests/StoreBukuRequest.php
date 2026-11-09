<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'judul' => ['required', 'string', 'min:3', 'max:150'],
            'penulis' => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => [
                'required',
                'integer',
                'between:1900,' . date('Y')
            ],
            'stok' => ['required', 'integer', 'min:0'],
        ];
    }   

    public function messages(): array
    {
        return [
            'kategori_id.required' => 'Kategori wajib diisi.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',

            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.min' => 'Judul buku minimal 3 karakter.',
            'judul.max' => 'Judul buku maksimal 150 karakter.',

            'penulis.required' => 'Penulis wajib diisi.',
            'penulis.string' => 'Penulis buku harus berupa teks.',
            'penulis.min' => 'Penulis minimal 3 karakter.',
            'penulis.max' => 'Penulis maksimal 100 karakter.',

            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.between' =>
                'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.integer' => 'Stok buku harus berupa bilangan bulat.',
            'stok.min' => 'Stok buku tidak boleh kurang dari 0.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kategori_id' => 'kategori',
            'judul' => 'judul buku',
            'penulis' => 'penulis buku',
            'tahun_terbit' => 'tahun terbit',
            'stok' => 'stok buku',
        ];
    }
}
