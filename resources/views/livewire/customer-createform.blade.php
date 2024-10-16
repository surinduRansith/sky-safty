<div class="border border-gray-300 rounded p-4 max-w-md mx-auto mt-10">

<form wire:submit="createCustomer" >

  <label class="input input-bordered flex items-center gap-2 mb-4">
    <input type="text" wire:model="name" class="grow" placeholder="Customer Name" />
  </label>
  @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

  <label class="input input-bordered flex items-center gap-2 mb-4">
    <input type="text" wire:model="company" class="grow" placeholder="Company Name" />
  </label>
  @error('company') <span class="text-red-500">{{ $message }}</span> @enderror

  <label class="input input-bordered flex items-center gap-2 mb-4">
    <input type="text" wire:model="address" class="grow" placeholder="Company Address" />
  </label>
  @error('address') <span class="text-red-500">{{ $message }}</span> @enderror

  <label class="input input-bordered flex items-center gap-2 mb-4">
    <input type="text" wire:model="email" class="grow" placeholder="Customer Email" />
  </label>
  @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

  <label class="input input-bordered flex items-center gap-2">
    <input type="text" wire:model="phone" class="grow" placeholder="Phone Number" />
  </label>
  @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror

<br>
  <button type="submit" class="btn btn-success "> 
    Save
    <span class="loading loading-spinner text-primary" wire:loading></span>
  </button>
</form>


</div>
