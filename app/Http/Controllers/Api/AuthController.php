<?php

namespace App\Http\Controllers\Api;

use App\Constants\RequestKeys;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\BaseResource;
use Auth;
use Config;
use Cookie;
use Illuminate\Validation\ValidationException;
use Lang;
use Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email'    => $request->get(RequestKeys::EMAIL),
            'password' => $request->get(RequestKeys::PASSWORD),
        ];

        $token = Auth::attempt($credentials);
        if (!$token) {
            throw ValidationException::withMessages([
                RequestKeys::PASSWORD => [Lang::get('auth.failed')],
            ]);
        }

        $user = Auth::user();

        $refreshToken = Auth::setTTL(Config::get('jwt.refresh_ttl'))->tokenById($user->getKey());
        $cookie       = Cookie::make('jwt', $refreshToken, Config::get('jwt.refresh_ttl'), null, null, false);

        return (new BaseResource($user, $token))->response()->cookie($cookie)
            ->setStatusCode(HttpResponse::HTTP_CREATED);
    }

    public function logout()
    {
        Auth::invalidate(true);
        Auth::logout();

        return Response::noContent();
    }
}
