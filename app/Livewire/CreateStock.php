<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Size;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreStockRequest;

class CreateStock extends Component
{
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
        // Prepare data for validation
        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'sizes' => $this->sizes,
        ];

        // Validate using StoreStockRequest
        $validator = Validator::make($data, (new StoreStockRequest())->rules());

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            return;
        }

        // Create the stock
        $stock = Stock::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            // 'image' => $this->image, // Handle image upload if needed
        ]);

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

        session()->flash('success', 'Stock created successfully!');
    }

    public function render()
    {
        return view('livewire.create-stock');
    }
}
