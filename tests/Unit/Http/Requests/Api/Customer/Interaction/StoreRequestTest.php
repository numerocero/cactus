<?php

namespace Tests\Unit\Http\Requests\Api\Customer\Interaction;

use App\Constants\RequestKeys;
use App\Http\Requests\Api\Customer\Interaction\StoreRequest;
use Lang;
use Str;
use Tests\Unit\Http\Requests\RequestTestCase;

class StoreRequestTest extends RequestTestCase
{
    protected string $requestClass = StoreRequest::class;

    /** @test */
    public function its_description_is_required()
    {
        $request = $this->formRequest($this->requestClass);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::DESCRIPTION]);
        $request->assertValidationMessages([Lang::get('validation.required', ['attribute' => RequestKeys::DESCRIPTION])]);
    }

    /** @test */
    public function its_description_should_be_a_string()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::DESCRIPTION => ['array'],
        ]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::DESCRIPTION]);
        $request->assertValidationMessages([Lang::get('validation.string', ['attribute' => RequestKeys::DESCRIPTION])]);
    }

    /** @test */
    public function its_description_should_be_less_than_256_characters()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::DESCRIPTION => Str::random(256),
        ]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::DESCRIPTION]);
        $request->assertValidationMessages([Lang::get('validation.max.string', ['attribute' => RequestKeys::DESCRIPTION, 'max' => '255'])]);
    }
}
