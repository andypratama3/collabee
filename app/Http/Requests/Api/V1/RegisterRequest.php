<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', new Enum(UserRole::class)],
        ];

        if ($this->user_type === UserRole::BRAND->value) {
            $rules['brand_name'] = ['required', 'string', 'max:255'];
            $rules['industry'] = ['required', 'string', 'max:255'];
            $rules['location'] = ['nullable', 'string', 'max:255'];
            $rules['website'] = ['nullable', 'url', 'max:255'];
        }

        if ($this->user_type === UserRole::KOL->value) {
            $rules['display_name'] = ['required', 'string', 'max:255'];
            $rules['category'] = ['required', 'string', 'max:255'];
            $rules['location'] = ['nullable', 'string', 'max:255'];
            $rules['bio'] = ['nullable', 'string', 'max:1000'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'user_type.required' => 'Tipe pengguna wajib dipilih.',
            'brand_name.required' => 'Nama brand wajib diisi.',
            'industry.required' => 'Industri wajib diisi.',
            'display_name.required' => 'Nama tampilan wajib diisi.',
            'category.required' => 'Kategori wajib diisi.',
        ];
    }
}
