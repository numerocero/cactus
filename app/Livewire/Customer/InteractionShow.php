<?php

namespace App\Livewire\Customer;

use App\Http\Requests\Api\Customer\Interaction\UpdateRequest;
use App\Models\Customer;
use App\Models\Interaction;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InteractionShow extends Component
{
    public Customer    $customer;
    public Interaction $interaction;

    #[Validate]
    public string $description;

    public function rules()
    {
        return (new UpdateRequest())->rules();
    }

    public function mount(Customer $customer, Interaction $interaction)
    {
        $this->customer    = $customer;
        $this->interaction = $interaction;
        $this->description = $interaction->description;
    }

    public function render()
    {
        return view('livewire.customer.interaction-show');
    }

    public function update()
    {
        $this->validate();

        $this->interaction->description = $this->description;
        $this->interaction->save();

        $this->dispatch('interaction-updated');
    }
}
