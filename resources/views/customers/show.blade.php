<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200 mb-6">
            {{ __('Edit Customer') }}
        </h2>

        
            <div>
                <x-input-label for="company" :value="__('Company Name')" />
                <x-text-input id="company" type="text" class="block mt-1 w-full"
                    name="company"  />
                <x-input-error :messages="$errors->get('customer.company')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="name" :value="__('Customer Name')" />
                <x-text-input  id="name" type="text" class="block mt-1 w-full"
                    name="name" required />
                <x-input-error :messages="$errors->get('customer.name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Customer Email')" />
                <x-text-input  id="email" type="email" class="block mt-1 w-full"
                    name="email" required />
                <x-input-error :messages="$errors->get('customer.email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input  id="phone" type="text" class="block mt-1 w-full"
                    name="phone" required />
                <x-input-error :messages="$errors->get('customer.phone')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6 space-x-3">
                <a href="{{ route('customers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Cancel') }}
                </a>

                <x-primary-button>
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>
     
    </div>
</x-app-layout>
