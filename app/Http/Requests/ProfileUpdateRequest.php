<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// =============================
// Request class untuk validasi update profile user
// Berisi: aturan validasi untuk nama dan email
// =============================

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * Aturan validasi untuk update profile user
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],  // Nama wajib diisi, string, maksimal 255 karakter
            'email' => [
                'required',                                // Email wajib diisi
                'string',                                  // Tipe data string
                'lowercase',                               // Email harus lowercase
                'email',                                   // Format email valid
                'max:255',                                 // Maksimal 255 karakter
                Rule::unique(User::class)->ignore($this->user()->id),  // Email unik kecuali untuk user yang sedang update
            ],
        ];
    }
}
