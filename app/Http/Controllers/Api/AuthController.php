<?php

namespace App\Http\Controllers\Api;

use App\Constants\RequestKeys;
use App\Handlers\Auth\LoginHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\BaseResource;
use Auth;
use Illuminate\Validation\ValidationException;
use Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $loginHandler = new LoginHandler();
        $loginHandler->handle($request->get(RequestKeys::EMAIL), $request->get(RequestKeys::PASSWORD));

        return (new BaseResource($loginHandler->getUser(), $loginHandler->getToken()))->response()
            ->cookie($loginHandler->getCookie())
            ->setStatusCode(HttpResponse::HTTP_CREATED);
    }

    public function logout()
    {
        Auth::invalidate(true);
        Auth::logout();

        return Response::noContent();
    }
}
