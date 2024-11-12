<?php

namespace App\Livewire;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditCustomer extends Component
{
    public $customer;
    #[Rule('required', 'string')]
    public $editname;
    #[Rule('required', 'string')]
    public $editemail;
    #[Rule('required', 'string')]
    public $editphone;
    #[Rule('required', 'string')]
    public $editcompany;
    #[Rule('required', 'string')]

    public $editaddress;

    public function mount( $customer ){

        $this->customer = $customer;
       
   

        $this->editname = $this->customer->name;
        $this->editemail = $this->customer->email;
        $this->editphone = $this->customer->phone;
        $this->editcompany = $this->customer->company;
        $this->editaddress = $this->customer->address;

    }


    public function update(){

        $data = [
            'name' => $this->editname,
            'company' => $this->editcompany,
            'address' => $this->editaddress,
            'phone'=>$this->editphone,
            'email' => $this->editemail
        ];

        $validate = $this->validate();

        
        $this->customer->update($data);
        return redirect()->route('customers.index')->with('success', 'Customer update successfully!');
    }
    public function render()
    {
        return view('livewire.edit-customer');
    }
}
