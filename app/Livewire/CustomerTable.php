<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;

class CustomerTable extends Component
{
    public $search;
    public $customerid;

    public function deleteCustomer( $customerid){

        $this-> customerid=$customerid; 


        //dd($this-> customerid);   
        Customer::where('id', $this->customerid)->delete();


        return redirect()->route('customers.index')->with('delete', 'Customer  deleted successfully.');
    }

    public function render()
    {
        return view('livewire.customer-table',[
            'customers'=> Customer::latest()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('company', 'like', '%' . $this->search . '%')
            ->paginate(5)
        ]);
    }
}
