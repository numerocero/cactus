<?php

namespace App\Livewire;

use App\Http\Requests\Api\Customer\StoreRequest;
use App\Models\Customer;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Session;

class Dashboard extends Component
{
    #[Locked]
    public string $apiToken;
    #[Validate]
    public string $name;
    #[Validate]
    public string $email;

    public function rules()
    {
        return (new StoreRequest())->rules();
    }

    public function mount()
    {
        $this->apiToken = Session::get('apiToken') ?? '';
    }

    #[On('customer-created')]
    public function render()
    {
        return view('livewire.dashboard', [
            'customers' => Customer::with([
                'interactions' => function(Builder $query) {
                    $query->latest()->first();
                },
            ])->paginate(),
        ]);
    }

    public function delete(string $customerId)
    {
        $customer = Customer::find($customerId);
        $customer->delete();
    }

    public function store()
    {
        $this->validate();

        Customer::create([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatch('customer-created');
    }
}
