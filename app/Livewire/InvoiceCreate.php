<?php

namespace App\Livewire;

use App\Models\Stock;
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

    public function save(){
       
        dd($this->invoiceitems);


    }

   

  
    public function render()
    {
      
        
        return view('livewire.invoice-create',[
            'stocks' => Stock::latest()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate(3)
        ]);

        
    }
}
