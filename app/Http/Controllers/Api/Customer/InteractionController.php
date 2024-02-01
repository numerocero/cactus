<?php

namespace App\Http\Controllers\Api\Customer;

use App\Constants\RequestKeys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\Interaction\StoreRequest;
use App\Http\Requests\Api\Customer\Interaction\UpdateRequest;
use App\Http\Resources\Models\InteractionResource;
use App\Models\Customer;
use App\Models\Interaction;
use Response;

class InteractionController extends Controller
{
    public function index(Customer $customer)
    {
        $interactions = $customer->interactions()->paginate();

        return  InteractionResource::collection($interactions);
    }

    public function store(StoreRequest $request, Customer $customer)
    {
        $interaction = new Interaction;
        $interaction->description = $request->get(RequestKeys::DESCRIPTION);
        $interaction->customer_id = $customer->getKey();
        $interaction->save();

        return new InteractionResource($interaction);
    }

    public function update(UpdateRequest $request, Customer $customer, Interaction $interaction)
    {
        $interaction->description = $request->get(RequestKeys::DESCRIPTION);
        $interaction->save();

        return new InteractionResource($interaction);
    }

    public function show(Customer $customer, Interaction $interaction)
    {
        return new InteractionResource($interaction);
    }

    public function delete(Customer $customer, Interaction $interaction)
    {
        $interaction->delete();

        return Response::noContent();
    }
}
