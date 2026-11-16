<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/** Validasi parameter query untuk halaman daftar (berita, agenda, kajian, galeri). */
class ListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'ustadz' => ['nullable', 'string', 'max:150'],
            'tema' => ['nullable', 'string', 'max:150'],
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
            'tab' => ['nullable', 'in:mendatang,selesai'],
            'page' => ['nullable', 'integer', 'min:1', 'max:100000'],
        ];
    }

    /** Parameter tidak valid: kembali ke halaman yang sama tanpa query, bukan halaman error. */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(redirect()->to($this->url()));
    }
}
