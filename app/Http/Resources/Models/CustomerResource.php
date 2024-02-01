<?php

namespace App\Http\Resources\Models;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function __construct(Customer $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'id'    => $this->resource->getRouteKey(),
            'name'  => $this->resource->name,
            'email' => $this->resource->email,
            'last_interaction_date' => $this->resource->interactions->first()?->created_at,
        ];
    }
}
