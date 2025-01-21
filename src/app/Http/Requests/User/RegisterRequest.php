<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;
use App\Models\User;

class RegisterRequest extends AbstractRequest
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
            User::NAME_ATTRIBUTE => ['string', 'required'],
            User::EMAIL_ATTRIBUTE => ['email', 'required'],
            User::PASSWORD_ATTRIBUTE => ['string', 'required'],
            User::PASSWORD_CONFIRMATION_FIELD => ['string', 'required'],
        ];
    }
}
