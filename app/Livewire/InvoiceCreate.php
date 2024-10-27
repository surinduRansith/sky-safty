<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Rule;
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

public $customerid;

#[Rule('required')]
    public $company;

    #[Rule('required')]
    public $address;
    #[Rule('required')]
    public $invoicedate;
    #[Rule('required')]
    public $duedate;
    
    //#[Rule('required|in:30 Day Credit,COD')]
  public $paymentmethod;
    public function mount()
    {
        // Set the current date as the default for invoicedate
        $this->invoicedate = now()->format('Y-m-d');
        $this->resetserach();
    }
    

    public function resetserach()
    {
        $this->customersearch = '';
        $this->customers = [];
        
    }
    
    
    public function addItem($stockcode){

        $this->stock = $stockcode;

        $this->itemdetails = Stock::findOrFail($this->stock);

            $this->invoiceitems[] = [
                'itemcode'=> $this->itemdetails->code,
                'itemname'=>$this->itemdetails->name,
                'qty'=>'1',
                'unitprice'=>'0',
                'discount'=>'0',
               
                ];
        
               
      
     
    }

   
  
    public function setcustomer($customerid){

        $customerdetails  = Customer::findOrFail($customerid);

        $this->company = $customerdetails->company;
        $this->address = $customerdetails->address;
        $this->customerid = $customerdetails->id;

        $this->reset('customersearch');
        $this->customers = [];
        
    }
  
    public function save()
    {
        
       
        foreach ($this->invoiceitems as $item) {
           
        
        // Check if customer ID exists before proceeding
        if (empty($this->customerid)) {
            session()->flash('error', 'Please select a customer before saving the order.');
            return;
        }
        if (empty($this->paymentmethod)) {
            session()->flash('error', 'Please select a payment method before saving the order.');
            return;

        }
    
        // Create the order with customer_id and invoice id
        $order = Order::create([
            'id' => $this->invoiceid,
            'customer_id' => $this->customerid,
            'paymentmethod' => $this->paymentmethod,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    //dd($this->invoiceitems);
        // Loop through invoice items to add order items
        foreach ($this->invoiceitems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'stock_id' => $item['itemcode'],
                'quantity' => $item['qty'],
                'unit_price' => $item['unitprice'],
                'discount' => $item['discount'],
                'total_discount' => $this->totaldiscount,
                'invoicedate' => $this->invoicedate,
                'duedate' => $this->duedate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Clear the items after saving
        $this->reset(['invoiceitems','company','address','customerid','paymentmethod']);

        session()->flash('success', 'Order saved successfully.');
    }
    
}

  
    public function render()
    {
       if($this->customersearch!=''){
        $this->customers = Customer::where('name', 'like', '%'.$this->customersearch.'%')
        ->orWhere('company', 'like', '%' . $this->customersearch . '%')
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
