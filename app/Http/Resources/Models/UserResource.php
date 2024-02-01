<?php

namespace App\Http\Resources\Models;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function __construct(User $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'id'    => $this->resource->getRouteKey(),
            'name'  => $this->resource->name,
            'email' => $this->resource->email,
        ];
    }
}
