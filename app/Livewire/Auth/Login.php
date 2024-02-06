<?php

namespace App\Livewire\Auth;

use App\Constants\RouteNames;
use App\Http\Requests\Api\Auth\LoginRequest;
use Auth;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Session;

class Login extends Component
{
    #[Validate]
    public string $email;
    #[Validate]
    public string $password;

    public function rules()
    {
        return (new LoginRequest())->rules();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate();

        $credentials = [
            'email'    => $this->email,
            'password' => $this->password,
        ];

        if (Auth::guard('web')->attempt($credentials)){
            $request->session()->regenerate();
            $token = Auth::guard('api')->attempt($credentials);
            Session::put('apiToken', $token);

            return redirect()->route(RouteNames::WEB_DASHBOARD);
        } else {
            Session::flash('error', 'Invalid credentials.');
        }
    }
}
