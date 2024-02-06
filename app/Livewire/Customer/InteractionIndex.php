<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use App\Models\Interaction;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class InteractionIndex extends Component
{
    use WithPagination;

    public Customer $customer;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    #[On('interaction-created')]
    public function render()
    {
        return view('livewire.customer.interaction-index', [
            'interactions' => $this->customer->interactions()->latest()->paginate(),
        ]);
    }

    public function delete(string $interactionId)
    {
        $interaction = Interaction::find($interactionId);
        $interaction->delete();
    }
}
