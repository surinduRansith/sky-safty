<div class="border border-gray-300 rounded p-4 max-w-md mx-auto mt-10">

    

        <label class="input input-bordered flex items-center gap-2 mb-4">
            <input type="text" wire:model="editname" class="grow" placeholder="Customer Name" />
        </label>
        @error('editname')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <label class="input input-bordered flex items-center gap-2 mb-4">
            <input type="text" wire:model="editcompany" class="grow" placeholder="Company Name" />
        </label>
        @error('editcompany')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <label class="input input-bordered flex items-center gap-2 mb-4">
            <input type="text" wire:model="editaddress" class="grow" placeholder="Company Address" />
        </label>
        @error('editaddress')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <label class="input input-bordered flex items-center gap-2 mb-4">
            <input type="text" wire:model="editemail" class="grow" placeholder="Customer Email" />
        </label>
        @error('editemail')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <label class="input input-bordered flex items-center gap-2">
            <input type="text" wire:model="editphone" class="grow" placeholder="Phone Number" />
        </label>
        @error('editphone')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <br>
        <button type="button" wire:click="update" class="btn btn-success ">
            Save
            <span class="loading loading-spinner text-primary" wire:loading></span>
        </button>
        <a type="button" href="{{route('customers.index')}}" class="btn btn-error ">
            Cancel
           
        </a>
    


</div>
