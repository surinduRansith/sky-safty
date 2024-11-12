<div class="flex justify-center">




    @if ($hidden == '')
        <div class="card card-compact bg-base-100 w-96  shadow-xl pt-4">
            <!-- Image -->
            <figure>

                @foreach ($stocks as $index => $stock)
                    <img src="{{ asset('storage/' . $stock->image) }}" alt="Uploaded Image" class="w-full">
                @endforeach

            </figure>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Name -->
                <div class="mb-2">
                    <h2 class="card-title">{{ $name }}</h2>
                </div>

                <!-- Code -->
                <div class="mb-4">
                    <label class="font-bold">Code:</label>
                    <div>{{ $code }}</div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="font-bold">Description:</label>
                    <div>{{ $description }}</div>
                </div>

                <!-- Sizes -->
                <div class="mb-4">
                    <h3 class="font-bold ">Sizes</h3>
                    @if (count($sizes) > 0)
                        @foreach ($sizes as $index => $size)
                            <div class="flex items-center mb-2">
                                <span
                                    class="border rounded w-12   p-2 mr-2 {{ $index % 2 == 0 ? 'bg-yellow-200' : 'bg-blue-200' }} text-black">
                                    {{ $size['size'] }}
                                </span>
                                <span
                                    class="border rounded p-2 mr-2 {{ $index % 2 == 0 ? 'bg-green-200' : 'bg-red-200' }} text-black">
                                    {{ $size['quantity'] }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        <div>No sizes added</div>
                    @endif
                </div>

                <!-- Action Button -->
                <div class="card-actions justify-end">
                    <button wire:click="editstock" class="btn btn-success text-white font-bold py-2 px-4 rounded mt-2">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="card card-compact bg-base-100 w-96 shadow-xl pt-4">
            <!-- Image -->
            <figure>

                @foreach ($stocks as $index => $stock)
                    <img src="{{ asset('storage/' . $stock->image) }}" alt="Uploaded Image" class="w-full">
                @endforeach

            </figure>

            <!-- Card Body -->
            <div class="card-body ">
                <!-- Code -->
                <div class="mb-4">
                    <label for="code" class="block font-bold mb-2">Code:</label>
                    <input disabled type="text" id="code" wire:model.defer="code"
                        class="input input-bordered w-full max-w-xs">
                    @error('code')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block font-bold mb-2">Name:</label>
                    <input type="text" id="name" wire:model.defer="name"
                        class="input input-bordered w-full max-w-xs">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block font-bold mb-2">Description:</label>
                    <textarea id="description" wire:model.defer="description" class="input input-bordered w-full max-w-xs"></textarea>
                    @error('description')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label for="image" class="block font-bold mb-2">Image Upload:</label>
                    <input type="file" wire:model="image" accept="image/png, image/jpeg" id="image"
                        class="file-input file-input-bordered w-full max-w-xs" />
                    @error('image')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Sizes -->
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Sizes</h3>
                    @foreach ($sizes as $index => $size)
                        <div class="flex items-center mb-2">
                            <input type="text" wire:model.defer="sizes.{{ $index }}.size" placeholder="Size"
                                class="border rounded p-2 mr-2 w-20">
                            <input type="number" wire:model.defer="sizes.{{ $index }}.quantity"
                                placeholder="Quantity" class="border rounded p-2 mr-2 w-20">
                            <button type="button" wire:click="removeSize({{ $index }})"
                                class="text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm3 10.5a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0 0 1.5h6Z" clip-rule="evenodd" />
                                  </svg>
                            </button>
                        </div>

                        @error('sizes.' . $index . '.size')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        @error('sizes.' . $index . '.quantity')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    @endforeach
                    <button type="button" wire:click="addSize" class="btn text-blue-500 mt-2">+ Add Size</button>
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="card-actions justify-end mb-4">
                    @foreach ($stocks as $index => $stock)
                        <button wire:click="update({{ $stock->id }})"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                            Create Stock
                            <span class="loading loading-spinner text-primary" wire:loading></span>
                        </button>
                    @endforeach

                    <button wire:click="canceledit"
                        class="bg-red-500 text-white font-bold py-2 px-4 rounded">Cancel</button>
                </div>
            </div>
        </div>



    @endif

</div>
