<?php

namespace App\Handlers\Auth;

use App\Constants\RequestKeys;
use Auth;
use Config;
use Cookie as CookieFacade;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Lang;
use Symfony\Component\HttpFoundation\Cookie;

class LoginHandler
{
    protected Authenticatable $user;
    protected string $token;
    protected Cookie $cookie;

    /**
     * @throws ValidationException
     */
    public function handle(string $email, string $password)
    {
        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        $token = Auth::attempt($credentials);
        if (!$token) {
            throw ValidationException::withMessages([
                RequestKeys::PASSWORD => [Lang::get('auth.failed')],
            ]);
        }

        $user = Auth::user();

        $refreshToken = Auth::setTTL(Config::get('jwt.refresh_ttl'))->tokenById($user->getKey());
        $cookie       = CookieFacade::make('jwt', $refreshToken, Config::get('jwt.refresh_ttl'), null, null, false);

        $this->user = $user;
        $this->token = $token;
        $this->cookie = $cookie;
    }

    public function getUser(): ?Authenticatable
    {
        return $this->user;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getCookie(): ?Cookie
    {
        return $this->cookie;
    }
}
