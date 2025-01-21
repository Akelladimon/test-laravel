<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;
use App\Models\User;
use App\Rules\Password;

class LoginRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            User::EMAIL_ATTRIBUTE => 'required|email',
            User::PASSWORD_ATTRIBUTE => ['string','required'],
        ];
    }


}
