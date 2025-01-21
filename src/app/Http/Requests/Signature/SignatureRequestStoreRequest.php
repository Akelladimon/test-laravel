<?php

namespace App\Http\Requests\Signature;

use Illuminate\Foundation\Http\FormRequest;

class SignatureRequestStoreRequest extends FormRequest
{
    public function authorize()
    {
        // You can check if the user has permission to send a signature request here
        return true; // or return auth()->user()->can('send-signature-request');
    }

    public function rules()
    {
        return [
            'receiver_id' => 'required|exists:users,id',
            'document_id' => 'required|exists:documents,id',
        ];
    }

    // Optionally, you can define custom error messages here
    public function messages()
    {
        return [
            'receiver_id.required' => 'The receiver is required.',
            'document_id.required' => 'The document is required.',
        ];
    }
}
