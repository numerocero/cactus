<?php

namespace App\Http\Requests\Api\Customer\Interaction;

use App\Constants\RequestKeys;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            RequestKeys::DESCRIPTION => ['required', 'string', 'max:255'],
        ];
    }
}
