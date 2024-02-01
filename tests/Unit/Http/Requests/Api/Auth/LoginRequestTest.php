<?php

namespace Tests\Unit\Http\Requests\Api\Auth;

use App\Constants\RequestKeys;
use App\Http\Requests\Api\Auth\LoginRequest;
use Lang;
use Tests\Unit\Http\Requests\RequestTestCase;

class LoginRequestTest extends RequestTestCase
{
    protected string $requestClass = LoginRequest::class;

    /** @test */
    public function its_email_is_required()
    {
        $request = $this->formRequest($this->requestClass);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::EMAIL]);
        $request->assertValidationMessages([Lang::get('validation.required', ['attribute' => RequestKeys::EMAIL])]);
    }

    /** @test */
    public function its_email_should_be_a_string()
    {
        $request = $this->formRequest($this->requestClass, [RequestKeys::EMAIL => ['array']]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::EMAIL]);
        $request->assertValidationMessages([Lang::get('validation.string', ['attribute' => RequestKeys::EMAIL])]);
    }

    /** @test */
    public function its_email_should_be_an_email()
    {
        $request = $this->formRequest($this->requestClass, [RequestKeys::EMAIL => 'not an email']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::EMAIL]);
        $request->assertValidationMessages([Lang::get('validation.email', ['attribute' => RequestKeys::EMAIL])]);
    }

    /** @test */
    public function its_password_is_required()
    {
        $request = $this->formRequest($this->requestClass);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::PASSWORD]);
        $request->assertValidationMessages([Lang::get('validation.required', ['attribute' => RequestKeys::PASSWORD])]);
    }

    /** @test */
    public function its_password_should_have_at_least_6_characters()
    {
        $request = $this->formRequest($this->requestClass, [RequestKeys::PASSWORD => '12345']);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::PASSWORD]);
        $request->assertValidationMessages([
            Lang::get('validation.min.string', ['attribute' => RequestKeys::PASSWORD, 'min' => 6]),
        ]);
    }

    /** @test */
    public function it_should_pass_on_valid_data()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::EMAIL    => 'valid.email@example.com',
            RequestKeys::PASSWORD => '12345678',
        ]);

        $request->assertValidationPassed();
    }}
