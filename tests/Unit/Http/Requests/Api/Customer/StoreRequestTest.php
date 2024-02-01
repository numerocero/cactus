<?php

namespace Tests\Unit\Http\Requests\Api\Customer;

use App\Constants\RequestKeys;
use App\Http\Requests\Api\Customer\StoreRequest;
use Lang;
use Str;
use Tests\Unit\Http\Requests\RequestTestCase;

class StoreRequestTest extends RequestTestCase
{
    protected string $requestClass = StoreRequest::class;

    /** @test */
    public function its_name_is_required()
    {
        $request = $this->formRequest($this->requestClass);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::NAME]);
        $request->assertValidationMessages([Lang::get('validation.required', ['attribute' => RequestKeys::NAME])]);
    }

    /** @test */
    public function its_name_should_be_a_string()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::NAME => ['array value'],
        ]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::NAME]);
        $request->assertValidationMessages([Lang::get('validation.string', ['attribute' => RequestKeys::NAME])]);
    }

    /** @test */
    public function its_name_should_be_less_than_256_characters()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::NAME => Str::random(256),
        ]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::NAME]);
        $request->assertValidationMessages([Lang::get('validation.max.string', ['attribute' => RequestKeys::NAME, 'max' => '255'])]);
    }

    /** @test */
    public function its_email_is_required()
    {
        $request = $this->formRequest($this->requestClass);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::EMAIL]);
        $request->assertValidationMessages([Lang::get('validation.required', ['attribute' => RequestKeys::EMAIL])]);
    }

    /** @test */
    public function its_email_should_be_an_email()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::EMAIL => 'not email'
        ]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::EMAIL]);
        $request->assertValidationMessages([Lang::get('validation.email', ['attribute' => RequestKeys::EMAIL])]);
    }

    /** @test */
    public function it_should_pass_on_valid_data()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::NAME => 'a name',
            RequestKeys::EMAIL => 'test@example.com',
        ]);

        $request->assertValidationPassed();
    }
}
