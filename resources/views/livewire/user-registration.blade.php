<div class="border border-gray-300 rounded p-4 max-w-md mx-auto mt-10">

    <form wire:submit="register">
        <!-- Name -->
        <div>
            <label class="input input-bordered flex items-center gap-2 input-md">
                Name :
                <input type="text" wire:model="name" class="grow" placeholder="" />
            </label>
            @error('name')
                <p class="text-red-500">{{ $message }}  </p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label class="input input-bordered flex items-center gap-2 input-md">
                Email :
                <input type="email" wire:model="email" class="grow" placeholder="" />
            </label>
            @error('email')
                <p class="text-red-500">{{ $message }}  </p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="input input-bordered flex items-center gap-2 input-md">
                Password :
                <input type="password" wire:model="password" class="grow" placeholder="" />
            </label>
            @error('password')
                <p class="text-red-500">{{ $message }}  </p>
            @enderror

        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="input input-bordered flex items-center gap-2 input-md">
                Confirm Password :
                <input type="password" wire:model="password_confirmation" class="grow" placeholder="" />
            </label>
            @error('password_confirmation')
                <p class="text-red-500">{{ $message }}  </p>
            @enderror

        </div>
        

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

</div>
