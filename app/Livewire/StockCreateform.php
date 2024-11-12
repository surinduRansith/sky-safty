<?php

namespace App\Livewire;



use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Stock;
use App\Models\Size;

use Livewire\WithFileUploads;



class StockCreateform extends Component
{
 use WithFileUploads;

  
    public $name;

    public $code;

   
    public $description;


    public $image; // Handle image upload if needed

  
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
        $customMessages = [
            'sizes.required' => 'Please add at least one size.',
            'sizes.array' => 'Sizes must be in an array format.',
            'sizes.*.size.required' => 'The size field is required.',
            'sizes.*.size.string' => 'The size must be a valid string.',
            'sizes.*.quantity.required' => 'The quantity field is required.',
            'sizes.*.quantity.integer' => 'The quantity must be a valid number.',
            'sizes.*.quantity.min' => 'The quantity must be at least 1.',
        ];
        
   
        
        $validate = $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:stocks,code',
            'description' => 'required|nullable|string',
            'image' => 'nullable|image|sometimes|max:10240',
            'sizes' => 'required|array|min:1',
            'sizes.*.size' => 'required|string',
            'sizes.*.quantity' => 'required|integer|min:1',
        ],$customMessages);

        if ($this->image) {
            $validate['image']= $this->image->store('uploads', 'public');
            
        }

   

        $stock = Stock::create($validate);
        
        
    

        // Create associated sizes
        foreach ($this->sizes as $size) {
            $validate = $this->validate();
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
