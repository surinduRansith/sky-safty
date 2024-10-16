<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 justify-center">
        @if (session()->has('success'))
            <div role="alert" class="alert alert-success mb-4 max-w-md"  x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6 shrink-0 stroke-current"
                  fill="none"
                  viewBox="0 0 24 24">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @elseif (session()->has('delete'))
            <div role="alert" class="alert alert-success mb-4 max-w-md"
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6 shrink-0 stroke-current"
                  fill="none"
                  viewBox="0 0 24 24">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('delete') }}</span>
                @endif
             
        
        </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 justify-center">
        <!-- Page Heading -->
        <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200 mb-6">
            {{ __('Customers') }}
        </h2>
        <div class="overflow-x-auto">
           
                <a href="{{ route('customer.create') }}" class="btn btn-success">Enter Customer</a>
            </div>
            <br>
           <livewire:customer-table />
        </div>
    </div>
</x-app-layout>
