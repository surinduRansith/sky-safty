<?php

namespace App\Livewire;

use App\Models\Size;
use Illuminate\Support\Facades\Storage;

use App\Models\Stock;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowStockDetails extends Component
{
    use WithFileUploads;
    public $stockid;
    public $stocks;
  
    #[Rule('required|string|max:50')]
    public $name;
    #[Rule('required|string|max:50|unique:stocks,code')]
    public $code;

    #[Rule('nullable|string')]
    public $description;

    #[Rule('nullable|image|sometimes|max:10240')]
    public $image; // Handle image upload if needed

    #[Rule('required|array|min:1')]
    public $sizes = [];

    public $hidden = "";
    public function addSize()
    {
     
        $this->sizes[] = ['size' => '', 'quantity' => ''];
    }
    public function removeSize($index)
    {
        // Assuming you have a method to get the stock ID
        $stockId = Stock::all()->where('code',$this->stockid)->pluck('id')->first();
    
        // Get the size to be removed using the index
        $sizeToRemove = $this->sizes[$index];

    
    
        // Find the Size model instance using the size value and stock ID
       $sizeModel = Size::where('stock_id', $stockId)
                         ->where('size', $sizeToRemove['size'])
                         ->first();

        // If size model found, delete it
        if ($sizeModel) {
            $sizeModel->delete();
        }
       
       unset($this->sizes[$index]);
    
       // Re-index the sizes array to maintain numerical keys
       $this->sizes = array_values($this->sizes);
    }
    public function mount(){

        $this->stocks = Stock::all()->where('code',$this->stockid);

        foreach ($this->stocks as $stock) {
            $this->name = $stock->name;
            $this->code = $stock->code;
            $this->description = $stock->description;
            foreach ($stock->sizes as $size) {
                $this->sizes[] = ['size' => $size->size, 'quantity' => $size->quantity];
            }
        }
       
        
    }

    public function editstock(){
        $this->hidden = "hidden";
    }
    public function canceledit(){
        $this->hidden = "";
    }
 
    public function update($stockId)
    {
        // Validate input data
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Adjust rules as needed
        ]);

        // Find the specific stock instance by ID
        $stock = Stock::findOrFail($stockId);

        // Check if a new image is uploaded
        if ($this->image) {
            // Optionally delete the old image if needed
            if ($stock->image) {
                Storage::disk('public')->delete($stock->image);
            }

            // Store the new image and update the path
            $imagePath = $this->image->store('uploads', 'public');
        } else {
            // If no new image is uploaded, retain the existing image path
            $imagePath = $stock->image;
        }

        // Update the stock record with validated data, including the image
        $stock->update([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'image' => $imagePath, // Include the image path in the update
        ]);

        // Update or create associated sizes
        foreach ($this->sizes as $size) {
            $stock->sizes()->updateOrCreate(
                ['size' => $size['size']],
                ['quantity' => $size['quantity']]
            );
        }

        // Reset form fields if necessary
        $this->reset(['name', 'code', 'description', 'image', 'sizes']);
        $this->sizes = [['size' => '', 'quantity' => '']];

        return redirect()->route('stocks.show', $stockId)->with('success', 'Item updated successfully!');
    }

 
    public function render()
    {
        $this->stocks = Stock::all()->where('code',$this->stockid);


       
        return view('livewire.show-stock-details',[
            'stocks' => $this->stocks
        ]);
    }
}
