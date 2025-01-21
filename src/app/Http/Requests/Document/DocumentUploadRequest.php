<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUploadRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    */
    public function authorize(): bool
    {
        return true; // Adjust this if authorization logic is needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'document' => 'required|mimes:pdf|max:2048', // PDF only, max 2MB
        ];
    }

    /**
     * Custom messages for validation errors (optional).
     */
    public function messages(): array
    {
        return [
            'document.required' => 'A document file is required.',
            'document.mimes' => 'The document must be a PDF file.',
            'document.max' => 'The document must not exceed 2MB in size.',
        ];
    }
}
