<?php

namespace App\Livewire;

use App\Handlers\Auth\LoginHandler;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

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
        $loginHandler = new LoginHandler();

        try {
            $loginHandler->handle($this->email, $this->password);
        } catch (ValidationException $exception) {
            session()->flash('error', 'Incorrect email or password.');
        }

        session()->flash('message', "You are successfully logged in.");
    }
}
