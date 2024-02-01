<?php

namespace Http\Requests\Api\Customer;

use App\Constants\RequestKeys;
use App\Http\Requests\Api\Customer\IndexRequest;
use Lang;
use Tests\Unit\Http\Requests\RequestTestCase;

class IndexRequestTest extends RequestTestCase
{
    protected string $requestClass = IndexRequest::class;

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
    public function its_date_should_be_a_date()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::DATE => 'not a date',
        ]);

        $request->assertValidationFailed();
        $request->assertValidationErrors([RequestKeys::DATE]);
        $request->assertValidationMessages([Lang::get('validation.date', ['attribute' => RequestKeys::DATE])]);
    }

    /** @test */
    public function it_should_pass_on_valid_data()
    {
        $request = $this->formRequest($this->requestClass, [
            RequestKeys::NAME => 'a name',
            RequestKeys::DATE => '25-12-2024',
        ]);

        $request->assertValidationPassed();
    }
}
