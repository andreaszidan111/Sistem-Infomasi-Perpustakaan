<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule; 

class UpdateBukuRequest extends StoreBukuRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_id' => ['sometimes', 'exists:kategoris,id'],
            'judul' => ['sometimes', 'string', 'min:3', 'max:150'],
            'penulis' => ['sometimes', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => [
                'sometimes',
                'integer',
                'between:1900,' . date('Y')
            ],
            'stok' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
