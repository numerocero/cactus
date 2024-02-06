<?php

namespace App\Livewire;

use App\Http\Requests\Api\Auth\LoginRequest;
use Auth;
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
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email'    => $this->email,
            'password' => $this->password,
        ];

        if (Auth::guard('web')->attempt($credentials)){
            $user = Auth::user();
            $token = Auth::guard('api')->tokenById($user->getKey());
            Session::put('apiToken', $token);

            return redirect()->route('dashboard');
        } else {
            Session::flash('error', 'Invalid credentials.');
        }
    }
}
