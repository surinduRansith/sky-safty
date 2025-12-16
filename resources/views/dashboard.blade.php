<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 justify-items-center">

            {{-- Stock --}}
            <a href="{{ route('stocks.index') }}">
                <div class="card card-bordered hover:shadow-lg hover:bg-gray-100 transition w-64">
                    <figure class="p-3">
                        <img
                            class="h-36 w-36 mx-auto object-contain rounded-xl"
                            src="{{ asset('images/stocksicon.jpeg') }}"
                            alt="Stock">
                    </figure>
                    <div class="card-body py-3">
                        <h1 class="text-center font-bold text-lg">Stock</h1>
                    </div>
                </div>
            </a>

            {{-- Quotation --}}
            <a href="{{ route('quotation.create') }}">
                <div class="card card-bordered hover:shadow-lg hover:bg-gray-100 transition w-64">
                    <figure class="p-3">
                        <img
                            class="h-36 w-36 mx-auto object-contain rounded-xl"
                            src="{{ asset('images/quoteicon.jpeg') }}"
                            alt="Quotation">
                    </figure>
                    <div class="card-body py-3">
                        <h1 class="text-center font-bold text-lg">Quotation</h1>
                    </div>
                </div>
            </a>

            {{-- Invoice --}}
            <a href="{{ route('orders.index') }}">
                <div class="card card-bordered hover:shadow-lg hover:bg-gray-100 transition w-64">
                    <figure class="p-3">
                        <img
                            class="h-36 w-36 mx-auto object-contain rounded-xl"
                            src="{{ asset('images/invoiceicon.jpeg') }}"
                            alt="Invoice">
                    </figure>
                    <div class="card-body py-3">
                        <h1 class="text-center font-bold text-lg">Invoice</h1>
                    </div>
                </div>
            </a>

            {{-- Reports --}}
            <a href="{{ route('report.show') }}">
                <div class="card card-bordered hover:shadow-lg hover:bg-gray-100 transition w-64">
                    <figure class="p-3">
                        <img
                            class="h-36 w-36 mx-auto object-contain rounded-xl"
                            src="{{ asset('images/report.jpeg') }}"
                            alt="Reports">
                    </figure>
                    <div class="card-body py-3">
                        <h1 class="text-center font-bold text-lg">Reports</h1>
                    </div>
                </div>
            </a>

            {{-- Customer Details --}}
            <a href="{{ route('customers.index') }}">
                <div class="card card-bordered hover:shadow-lg hover:bg-gray-100 transition w-64">
                    <figure class="p-3">
                        <img
                            class="h-36 w-36 mx-auto object-contain rounded-xl"
                            src="{{ asset('images/custom.jpeg') }}"
                            alt="Customer Details">
                    </figure>
                    <div class="card-body py-3">
                        <h1 class="text-center font-bold text-lg">Customer Details</h1>
                    </div>
                </div>
            </a>

            {{-- Sample Order --}}
            <a href="{{ route('sampleorder.show') }}">
                <div class="card card-bordered hover:shadow-lg hover:bg-gray-100 transition w-64">
                    <figure class="p-3">
                        <img
                            class="h-36 w-36 mx-auto object-contain rounded-xl"
                            src="{{ asset('images/sampleorder.jpeg') }}"
                            alt="Sample Order">
                    </figure>
                    <div class="card-body py-3">
                        <h1 class="text-center font-bold text-lg">Sample Order</h1>
                    </div>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
