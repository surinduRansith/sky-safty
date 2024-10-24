<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Stock;
use App\Models\Size;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreStockRequest;
use Livewire\WithFileUploads;



class StockCreateform extends Component
{
 use WithFileUploads;

    #[Rule('required|string|max:50')]
    public $name;
    #[Rule('required|string|max:50|unique:stocks,code')]
    public $code;

    #[Rule('nullable|string')]
    public $description;

    #[Rule('nullable|image|sometimes|max:10240')]
    public $image; // Handle image upload if needed

    #[Rule('required|array|min:1')]
    public $sizes = [
        ['size' => '', 'quantity' => ''],
    ];


    
    
    public function addSize()
    {
     
        $this->sizes[] = ['size' => '', 'quantity' => ''];
    }

    public function removeSize($index)
    {
        unset($this->sizes[$index]);
        $this->sizes = array_values($this->sizes);
    }

    public function store()
    {
        

        $validate = $this->validate();

        if ($this->image) {
            $validate['image']= $this->image->store('uploads', 'public');
            
        }

   

        $stock = Stock::create($validate);
        
        

        // Create associated sizes
        foreach ($this->sizes as $size) {
            Size::create([
                'stock_id' => $stock->id,
                'size' => $size['size'],
                'quantity' => $size['quantity'],
            ]);
        }

       

        // Reset form fields
        $this->reset(['name', 'code', 'description', 'image', 'sizes']);
        $this->sizes = [['size' => '', 'quantity' => '']];

        return redirect()->route('stocks.index')->with('success', 'Item Add successfully!');
      
    }

   
    public function render()
    {
        return view('livewire.stock-createform');
    }
}
