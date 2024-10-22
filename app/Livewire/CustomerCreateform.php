<?php

namespace App\Livewire;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CustomerCreateform extends Component
{

    public $name;
    public $email;
    public $phone;
    public $company;

    public $address;

    public function createCustomer(){
        $data = [
            'name' => $this->name,
            'company' => $this->company,
            'address' => $this->address,
            'email' => $this->email,
            'phone'=>$this->phone
        ];

    

        $validator = Validator::make($data, (new StoreCustomerRequest())->rules());

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            return;
        }

        Customer::create([
            'name' => $this->name,
            'company' => $this->company,
            'address' => $this->address,
            'email' => $this->email,
            'phone'=>$this->phone
        ]

        );
        
        return redirect()->route('customers.index')->with('success', 'Customer Add successfully!');
        
    

        // $this->reset([
        //     'name',
        //     'company',
        //     'address',
        //     'email',
        //     'phone']);
    }


    public function render()
    {
        return view('livewire.customer-createform');
    }
}
