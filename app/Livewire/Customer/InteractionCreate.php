<?php

namespace App\Livewire\Customer;

use App\Http\Requests\Api\Customer\Interaction\StoreRequest;
use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InteractionCreate extends Component
{
    public Customer $customer;
    #[Validate]
    public string $description;

    public function rules()
    {
        return (new StoreRequest())->rules();
    }

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function render()
    {
        return view('livewire.customer.interaction-create');
    }

    public function store()
    {
        $this->validate();

        $this->customer->interactions()->create([
            'description' => $this->description,
        ]);

        $this->dispatch('interaction-created');
    }
}
