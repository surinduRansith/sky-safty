<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

   
    
        <div class="flex flex-row h-screen justify-center items-center">
            
            <a href="{{route('stocks.index')}}">
                <div class="mx-3 card card-bordered hover:shadow-lg hover:bg-gray-100">
                    <figure>
                        <img class="h-64 w-64 object-center" src="{{ asset('images/stocksicon.jpg') }}" alt="Stock Icon" />
                    </figure>
                    <div class="card-body">
                        <h1 class="text-center font-bold text-2xl">Stock</h1>
                    </div>
                </div>
            </a>
    
            <a href="#">
                <div class="mx-3 card card-bordered hover:shadow-lg hover:bg-gray-100">
                    <figure>
                        <img class="h-64 w-64 object-center" src="{{ asset('images/quoteicon.jpg') }}" alt="Quotation Icon" />
                    </figure>
                    <div class="card-body">
                        <h1 class="text-center font-bold text-2xl">Quotation</h1>
                    </div>
                </div>
            </a>
    
            <a href="{{route('orders.index')}}">
                <div class="mx-3 card card-bordered hover:shadow-lg hover:bg-gray-100">
                    <figure>
                        <img class="h-64 w-64 object-center" src="{{ asset('images/invoiceicon.jpg') }}" alt="Invoice Icon" />
                    </figure>
                    <div class="card-body">
                        <h1 class="text-center font-bold text-2xl">Invoice</h1>
                    </div>
                </div>
            </a>
    
            <a href="{{route('customers.index')}}">
                <div class="mx-3 card card-bordered hover:shadow-lg hover:bg-gray-100">
                    <figure>
                        <img class="h-64 w-64 object-center" src="{{ asset('images/custom.jpg') }}" alt="Customer Details Icon" />
                    </figure>
                    <div class="card-body">
                        <h1 class="text-center font-bold text-2xl">Customer Details</h1>
                    </div>
                </div>
            </a>
    
        </div>
   
    
</x-app-layout>
