<?php

use App\Models\Customer;
use Livewire\Component;

class EditCustomer extends Component
{
    public $customer;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function updateCustomer()
    {
        $this->validate([
            'customer.company' => 'required|string|max:255',
            'customer.name' => 'required|string|max:255',
            'customer.email' => 'required|email|max:255',
            'customer.phone' => 'required|string|max:255',
        ]);

        $this->customer->save();

        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.edit-customer');
    }
}
