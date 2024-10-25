<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceCreate extends Component
{

    use WithPagination;
    public $search;
    public  $stock;

    public $itemdetails;
    public $itemtotal=0;
    public $subtotal = 0;
    public $totaldiscount = 0;

    public $totalAmount = 0; 


    public $invoiceitems=[];

    
    public $customersearch;

    public $customers;

    public $invoiceid;


    public $name;
    public $email;
    public $phone;
    public $company;

    public $address;

    
  

    // public function customerSearch(){

    //     $this->customers = 

    //     // dd($this->customers);

    //     dd($this->customersearch);
    // }
    


    
    
    public function addItem($stockcode){

        $this->stock = $stockcode;

        $this->itemdetails = Stock::findOrFail($this->stock);

            $this->invoiceitems[] = [
                'itemcode'=> $this->itemdetails->code,
                'itemname'=>$this->itemdetails->name,
                'qty'=>'1',
                'unitprice'=>'0',
                'discount'=>'',
               
                ];
        
               //dd($this->invoiceitems);
      
     
    }

   

    public function setcustomer($customerid){

        $customerdetails  = Customer::findOrFail($customerid);

        $this->name = $customerdetails->name;
        $this->email = $customerdetails->email;
        $this->phone = $customerdetails->phone;
        $this->company = $customerdetails->company;
        $this->address = $customerdetails->address;

        $this->reset('customersearch');
    $this->customers = [];
        
    }

    public function save(){
       
        dd($this->invoiceitems);


    }
   

  
    public function render()
    {
       if($this->customersearch!=''){
        $this->customers = Customer::where('name', 'like', '%'.$this->customersearch.'%')
        ->get()
        ->toArray();
       }


       $this->invoiceid = DB::table('orders')->max('id') + 1;
       
        return view('livewire.invoice-create',[
            'stocks' => Stock::latest()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate(3),
          
        ]);

        
    }
}
