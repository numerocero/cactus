<?php

namespace App\Http\Requests\Api\Auth;

use App\Constants\RequestKeys;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            RequestKeys::EMAIL => ['required', 'string', 'email:strict'],
            RequestKeys::PASSWORD => ['required', Password::min(6)],
        ];
    }
}
