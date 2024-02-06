<?php

namespace App\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Session;

class Dashboard extends Component
{
    #[Locked]
    public string $apiToken;

    public function mount()
    {
        $this->apiToken = Session::get('apiToken') ?? '';
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
