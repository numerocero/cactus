<?php

namespace App\Http\Resources\Models;

use App\Models\Interaction;
use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
{
    public function __construct(Interaction $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'id'          => $this->resource->getRouteKey(),
            'description' => $this->resource->description,
            'created_at'  => $this->resource->created_at,
        ];
    }
}
