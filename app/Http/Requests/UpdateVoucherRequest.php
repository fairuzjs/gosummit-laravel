<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVoucherRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vouchers', 'code')->ignore($this->voucher),
            ],
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:0',
            'user_usage_limit' => 'nullable|integer|min:1',
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
            'code.required' => 'Kode voucher wajib diisi.',
            'code.unique' => 'Kode voucher sudah digunakan.',
            'name.required' => 'Nama voucher wajib diisi.',
            'type.required' => 'Tipe voucher wajib dipilih.',
            'type.in' => 'Tipe voucher harus percentage atau fixed.',
            'value.required' => 'Nilai voucher wajib diisi.',
            'value.min' => 'Nilai voucher tidak boleh negatif.',
            'valid_until.after_or_equal' => 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
            'usage_limit.min' => 'Batas penggunaan tidak boleh negatif.',
            'user_usage_limit.min' => 'Batas penggunaan per user minimal 1.',
        ];
    }
}
