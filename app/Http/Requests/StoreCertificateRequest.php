<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'certificatetype' => 'required|string|in:ISO Certificate,Training Certificate,C-TPAT Certificate',
            'certificatenumber' => 'required|string|max:255',
            'certificate' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'certificate.mimes' => 'The certificate must be a PDF file.',
            'certificate.max' => 'The certificate file size must not exceed 10MB.',
        ];
    }
}
