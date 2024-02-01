<?php

namespace App\Http\Controllers\Api;

use App\Constants\RequestKeys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\IndexRequest;
use App\Http\Requests\Api\Customer\StoreRequest;
use App\Http\Requests\Api\Customer\UpdateRequest;
use App\Http\Resources\Models\CustomerResource;
use App\Models\Customer;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Response;

class CustomerController extends Controller
{
    public function index(IndexRequest $request)
    {
        $validated = $request->validated();

        $pageQuery = Customer::with(['interactions' => function(Builder $query){
            $query->latest()->first();
        }]);

        if ($name = $request->get(RequestKeys::NAME)) {
            $pageQuery->where('name', 'like', "%$name%");
        }
        if ($request->get(RequestKeys::DATE)) {
            $pageQuery->whereHas('interactions', function(Builder $query) use ($request) {
                $query->where('created_at', '=', $request->get(RequestKeys::DATE));
            });
        }

        $page = $pageQuery->paginate();
        $page->appends($validated);

        return CustomerResource::collection($page);
    }

    public function store(StoreRequest $request)
    {
        $customer = new Customer;
        $customer->name = $request->get(RequestKeys::NAME);
        $customer->email = $request->get(RequestKeys::EMAIL);
        $customer->save();

        Return new CustomerResource($customer);
    }

    public function update(UpdateRequest $request, Customer $customer)
    {
        $customer->load(['interactions' => function(Builder $query){
            $query->latest()->first();
        }]);
        $customer->name = $request->get(RequestKeys::NAME);
        $customer->email =$request->get(RequestKeys::EMAIL);
        $customer->save();

        return new CustomerResource($customer);
    }

    public function show(Customer $customer)
    {
        $customer->load(['interactions' => function(Builder $query){
            $query->latest()->first();
        }]);

        return new CustomerResource($customer);
    }

    public function delete(Customer $customer)
    {
        $customer->delete();

        return Response::noContent();
    }
}
