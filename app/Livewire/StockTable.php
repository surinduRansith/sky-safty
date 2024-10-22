<?php

namespace App\Livewire;

use App\Models\Stock;
use Livewire\Component;

class StockTable extends Component
{
    public $search;
    public  $stock;

    public function deleteStock( $stock){

        $this-> stock=$stock; 
        //dd($this-> stock);   
        Stock::where('id', $this->stock)->delete();


        return redirect()->route('stocks.index')->with('delete', 'Stock deleted successfully.');
    }
    public function render()
    {    
        return view('livewire.stock-table',[
            'stocks' => Stock::latest()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate(5)
        ]);
    }
}
