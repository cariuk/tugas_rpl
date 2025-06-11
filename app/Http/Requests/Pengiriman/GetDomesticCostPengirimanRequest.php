<?php

namespace App\Http\Requests\Pengiriman;

use Illuminate\Foundation\Http\FormRequest;

class GetDomesticCostPengirimanRequest extends FormRequest
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
            'destination' => 'required',
            'weight' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'destination.required' => 'Tujuan Pengiriman Wajib Dicari dan Dipilih',
        ];
    }
}
