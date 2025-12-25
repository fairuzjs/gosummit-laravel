<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMountainRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'ticket_price' => 'required|integer|min:0',
            'height' => 'required|integer|min:0',
            'daily_quota' => 'required|integer|min:1',
            'status' => 'required|in:open,closed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama gunung wajib diisi.',
            'description.required' => 'Deskripsi gunung wajib diisi.',
            'location.required' => 'Lokasi gunung wajib diisi.',
            'ticket_price.required' => 'Harga tiket wajib diisi.',
            'ticket_price.min' => 'Harga tiket tidak boleh negatif.',
            'height.required' => 'Ketinggian gunung wajib diisi.',
            'height.min' => 'Ketinggian tidak boleh negatif.',
            'daily_quota.required' => 'Kuota harian wajib diisi.',
            'daily_quota.min' => 'Kuota harian minimal 1.',
            'status.required' => 'Status gunung wajib dipilih.',
            'status.in' => 'Status harus open atau closed.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
