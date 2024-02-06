<?php

namespace App\Livewire;

use App\Http\Requests\Api\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CustomerShow extends Component
{
    public Customer $customer;

    #[Validate]
    public string $name;
    #[Validate]
    public string $email;

    public function rules()
    {
        return (new UpdateRequest())->rules();
    }

    public function mount(Customer $customer)
    {
        $this->customer = $customer->load([
            'interactions' => function(Builder $query) {
                $query->latest()->first();
            },
        ]);
        $this->name = $customer->name;
        $this->email = $customer->email;
    }

    public function render()
    {
        return view('livewire.customer-show');
    }

    public function update()
    {
        $this->validate();

        $this->customer->name = $this->name;
        $this->customer->email = $this->email;
        $this->customer->save();

        $this->dispatch('customer-updated');
    }
}
