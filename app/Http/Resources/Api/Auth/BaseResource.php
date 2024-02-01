<?php

namespace App\Http\Resources\Api\Auth;

use App\Http\Resources\Models\UserResource;
use App\Models\User;

class BaseResource extends UserResource
{
    private string $token;

    public function __construct(User $user, string $token)
    {
        parent::__construct($user);

        $this->token = $token;
    }

    public function toArray($request): array
    {
        return array_replace_recursive(parent::toArray($request), [
            'token' => $this->token,
        ]);
    }
}
