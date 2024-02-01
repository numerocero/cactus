<?php

namespace App\Http\Requests\Api\Customer;

use App\Constants\RequestKeys;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            RequestKeys::NAME => ['required', 'string', 'max:255'],
            RequestKeys::EMAIL => ['required', 'email:strict'],
        ];
    }
}
