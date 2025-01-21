<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class SignDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can modify this to check if the user is authorized to sign a document
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document_id' => 'required|exists:documents,id', // Ensure document exists in the database
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure signature is an image file
            'receiver_id' => 'required|exists:users,id',
            'positionX' => 'numeric',
            'positionY' => 'numeric',
            'positionW' => 'numeric',
        ];
    }

    /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'document_id.required' => 'The document ID is required.',
            'document_id.exists' => 'The document does not exist.',
            'signature.required' => 'A signature is required.',
            'signature.image' => 'The signature must be an image.',
            'signature.mimes' => 'The signature must be a jpeg, png, jpg, gif, or svg file.',
            'signature.max' => 'The signature image must not exceed 2MB.',
        ];
    }
}
