<?php

namespace App\Http\Requests\Api\Customer;

use App\Constants\RequestKeys;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            RequestKeys::NAME => ['nullable', 'string'],
            RequestKeys::DATE => ['nullable', 'date'],
        ];
    }
}
