<?php

namespace App\Livewire;

use App\Models\companyDetails;
use App\Models\Customer;
use App\Models\sampleorder;
use App\Models\sampleorderitems;
use App\Models\Size;
use App\Models\Stock;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;

class Sampleitemorder extends Component
{
     use WithPagination;
    public $search;
    public  $stock;

    public $itemdetails;



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

    public $orderbills;
    public $orderitems;


    public $sizede;



    public function mount()
    {
        
        // Set the current date as the default for invoicedate
        $this->invoicedate = now()->format('Y-m-d');
        $this->resetserach();

        // companyDetails::insert([
        //     'company_name' => 'Sky Safety Equipment (Pvt) Ltd',
        //     'address' => 'No 70/7, Robert Gunawardana Mw, Thalangama South, Battaramulla, Sri Lanka',
        //     'phone_number' => '0768 459 499',
        //     'email' => 'skysafetyequipment@gmail.com',
        //     'brregistration' => 'PV 00342249',
        // ]);
    }

    public function updatedinvoicedate($value){
        //dd($value);
        $this->setDueDate();
    }

    public function updatedpaymentmethod($value)
    {
        // Update the due date when the payment method changes
        $this->setDueDate();
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
                'id'=>$this->itemdetails->id,
                'itemcode'=> $this->itemdetails->code,
                'itemname'=>$this->itemdetails->name,
                'qty'=>'1',
                'sizes'=>$this->itemdetails->sizes,
                'sizesselect'=>''
                

                ];
        
            
  
     
    }

    public function removeItem($key){

        unset($this->invoiceitems[$key]);

        $this->invoiceitems = array_values($this->invoiceitems);
    }
   
   
  
    public function setcustomer($customerid){

        $customerdetails  = Customer::findOrFail($customerid);

        $this->company = $customerdetails->company;
        $this->address = $customerdetails->address;
        $this->customerid = $customerdetails->id;
        $this->reset('customersearch');
        $this->customers = [];
        
    }
  
    public function validateOrder()
{
    $errors = []; // Initialize an empty array to hold error messages

    // Check if sizes are selected for each item
    foreach ($this->invoiceitems as $item) {
        if (empty($item['sizesselect'])) {
            $errors['sizesselect'] = 'Please select a size before saving the order.';
            break; // Stop the loop if one item is missing a size
        }
    }

    // Check if customer ID exists
    if (empty($this->customerid)) {
        $errors['customer'] = 'Please select a customer before saving the order.';
    }




    foreach ($this->invoiceitems as $item) {

        if($item['qty'] <= 0){

            $errors['qty'] = 'Quantity cannot be negative or 0 before saving the quotation.';
        }
        
        $sizes = Size::where('stock_id', $item['id'])
        ->where('size', $item['sizesselect'])
        ->get(); // Get the size record
    
        foreach ($sizes as $size) {
                
            if ($size['quantity'] < $item['qty'] || $size['quantity'] == 0) {

             
                $errors['qty'] = 'Not enough stock for the  selected  size before saving the quotation.';
            }
        }
        

       
        

    }
    
    
    // if($this->totaldiscount < 0){
    //     $errors['totaldiscount'] = 'Total Discount cannot be negative before saving the quotation.';
    // }
    // Flash error messages to the session if there are any
    if (!empty($errors)) {
        session()->flash('errors', $errors);
        return false; // Stop further processing if there are errors
    }

    return true; // Validation passed, continue with order creation
}


    public function save()
    {
       //dd($this->deliveryAddress);
        
        if (!$this->validateOrder()) {
            return; // Stop if validation fails
        }
        foreach ($this->invoiceitems as $item) {
        
           

        //pdf generate customer details
        $customerdetails = Customer::all()->where('id','=',$this->customerid);
        $companydetails = companyDetails::all()->first();
       
     
        $order = sampleorder::create([
            'id' => $this->invoiceid,
            'customer_id' => $this->customerid,
            'invoicedate' => $this->invoicedate,
        ]);
    
        foreach ($this->invoiceitems as $item) {
            sampleorderitems::create([
                'order_id' => $order->id,
                'stock_id' => $item['id'],
                'sizes' => $item['sizesselect'],
                'quantity' => $item['qty'],

            ]);

            

            // Assuming $item['itemcode'] and $item['sizesselect'] are defined
                $size = Size::where('stock_id', $item['id'])
                    ->where('size', $item['sizesselect'])
                ->first(); // Get the size record
                
                
                    if ($size->size && $size->quantity >= $item['qty']) {
                    // Decrease quantity safely
                $size->decrement('quantity', $item['qty']); 
                }

       }

        
    
    
        // Clear the items after saving
     $this->reset(['invoiceitems','company','address','customerid']);

        session()->flash('success', 'Order saved successfully.');
 
         //pdf generate bill and item details
        $this->orderbills= sampleorder::all()->where('id','=',$this->invoiceid);
        $this->orderitems = sampleorderitems::where('order_id', '=', $this->invoiceid)->get();

       //dd( $this->orderitems, $this->orderbills);

        

    
        $data=[
             'orderbills'=>$this->orderbills,
             'orderitems'=>$this->orderitems,
            'customerdetails'=>$customerdetails,
            'companydetails'=>$companydetails,

        ];

    


        $pdf=Pdf::loadView('sampleItemOrder.sampleorderpdf',$data)
        ->setPaper('letter', 'portrait');
        

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'sampleitemorder.pdf');
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

       
       $this->invoiceid = DB::table('sampleorders')->max('id') + 1;
          
        return view('livewire.sampleitemorder',[
            'stocks' => Stock::latest()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate(3),
          
        ]);

        
    }
}
