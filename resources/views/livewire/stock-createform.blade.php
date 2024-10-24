<div class=" flex  bg-white dark:bg-gray-800 shadow sm:rounded-lg  place-content-center px-8 py-8">
    <form wire:submit.prevent="store">
        @csrf

        <!-- Stock Name -->
        <div class="mb-4">
            <label for="name" class="block font-bold mb-2">Name:</label>
            <input type="text" id="name" wire:model.defer="name" class="input input-bordered w-full max-w-xs">
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Stock Code -->
        <div class="mb-4">
            <label for="code" class="block font-bold mb-2">Code:</label>
            <input type="text" id="code" wire:model.defer="code" class="input input-bordered w-full max-w-xs">
            @error('code') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block font-bold mb-2">Description:</label>
            <textarea id="description" wire:model.defer="description" class="input input-bordered w-full max-w-xs"></textarea>
            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="image" class="block font-bold mb-2">Image Upload:</label>
            <input type="file"wire:model="image" accept="image/png, image/jpeg" id="image" class="file-input file-input-bordered w-full max-w-xs" />
            @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>


        

        <!-- Dynamic Sizes -->
        <div class="mb-4">
            <h3 class="font-bold mb-2">Sizes</h3>
            @foreach ($sizes as $index => $size)
                <div class="flex items-center mb-2">
                    <input type="text" wire:model.defer="sizes.{{ $index }}.size" placeholder="Size" class="border rounded p-2 mr-2">
                    <input type="number" wire:model.defer="sizes.{{ $index }}.quantity" placeholder="Quantity" class="border rounded p-2 mr-2">
                    <button type="button" wire:click="removeSize({{ $index }})" class="text-red-500">Remove</button>
                </div>
                @error('sizes.' . $index . '.size') <span class="text-red-500">{{ $message }}</span> @enderror
                @error('sizes.' . $index . '.quantity') <span class="text-red-500">{{ $message }}</span> @enderror
            @endforeach
            <button type="button" wire:click="addSize" class=" btn text-blue-500 mt-2">+ Add Size</button>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                Create Stock
                <span class="loading loading-spinner text-primary" wire:loading></span>
            </button>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="text-green-500">
                {{ session('success') }}
            </div>
        @endif
    </form>
</div>