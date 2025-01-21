<?php

namespace App\Http\Requests\Signature;

use Illuminate\Foundation\Http\FormRequest;

class SignatureRequestUpdateStatusRequest extends FormRequest
{
    public function authorize()
    {
        // You can check if the user is authorized to update the status here
        return true; // or return auth()->user()->can('update-signature-request');
    }

    public function rules()
    {
        return [
            'status' => 'required|in:'.implode(',', [\App\Models\SignatureRequest::STATUS_SIGNED, \App\Models\SignatureRequest::STATUS_DECLINED]),
        ];
    }

    // Optionally, you can define custom error messages here
    public function messages()
    {
        return [
            'status.required' => 'The status is required.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
}
