<div>
    @if (session('success'))
        <div role="alert" class="alert alert-success mb-4 max-w-md" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)"
            x-show="show">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}done</span>
        </div>
    @endif
    @if (session('errorquantity'))
        <div role="alert" class="alert alert-error mb-4 max-w-md" x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)"
            x-show="show">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('errorquantity') }}done</span>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-4 ">
        <div>
            <label class="input input-bordered flex items-center gap-2  mb-4 max-w-md input-sm">
                <input type="text" wire:model.live.debounce.300ms="search" class="grow"
                    placeholder="Search Item Name or Code" />
            </label>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">
                            <label>
                                <input type="checkbox"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                            </label>
                        </th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Code') }}
                        </th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Name') }}
                        </th>
                        <th class="px-4 py-2 text-left font-medium text-gray-700 dark:text-gray-300"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($stocks as $index => $stock)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">
                            <td class="px-4 py-2">
                                <label>
                                    <input type="checkbox"
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                </label>
                            </td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                                {{ $stock['code'] }}
                            </td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                                {{ $stock['name'] }}
                            </td>
                            <td class="px-4 py-2">
                                <button wire:click="addItem({{ $stock['id'] }})"
                                    class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Add
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            {{ $stocks->links() }}

        </div>

        <div>
            @if (session()->has('errors'))
                @foreach (session('errors') as $error)
                    <div role="alert" class="alert alert-error mb-4 " x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)"
                        x-show="show">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            @endif


            <div class="grid grid-cols-2 gap-4 pt-1 px-4">
                <div class="relative max-w-md ">
                    <input type="text"
                        class="input input-bordered flex-grow flex items-center w-full mb-4 gap-2 input-sm"
                        placeholder="Search Customer..." wire:model.live.debounce.300ms="customersearch"
                        wire:keydown.escape="resetserach" wire:keydown.tab="resetserach"
                        wire:keydown.arrow-up="decrementHighlight" wire:keydown.arrow-down="incrementHighlight"
                        wire:keydown.enter="selectContact" />



                    @if (!empty($customersearch))
                        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetserach"></div>

                        <div
                            class="absolute top-full mt-1 w-full bg-gray-100 border border-gray-300 rounded-lg shadow-lg z-10 list-group">
                            @if (!empty($customers))
                                @foreach ($customers as $i => $customer)
                                    <div
                                        class="px-4 py-2 dark:hover:bg-blue-400 cursor-pointer border border-gray-300 rounded-lg shadow-lg">
                                        <button wire:click.prevent="setcustomer({{ $customer['id'] }})"
                                            class="w-full text-left">
                                            <span class="dark:text-blue-900"> {{ $customer['company'] }} </span>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="list-item">No results!</div>
                            @endif
                        </div>
                    @endif


                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Invoice ID : <span class="text-white-500">{{ $invoiceid }}</span>
                    </label>
                </div>
            </div>





            <div class="grid grid-cols-2 gap-4 pt-1 px-4 ">

                <div>


                    <label class="input input-bordered flex items-center gap-2 input-sm">
                        Name :
                        <input type="text" wire:model="company" class="grow" placeholder="Company Name" />
                    </label>
                    @error('company')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Address :
                        <input type="text" wire:model="address" class="grow" placeholder="Company Address" />
                    </label>
                    @error('address')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Delivery :<input type="text" wire:model="deliveryAddress" class="grow"
                            placeholder="Delivery Address" />
                    </label>
                    @error('deliveryAddress')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <select wire:model="paymentmethod" class="select select-sm select-bordered w-full max-w-xs">
                        <option selected>Select Payment Method</option>
                        <option value="30 Day Credit">30 Day Credit</option>
                        <option value="COD">COD</option>
                    </select>
                    @error('paymentmethod')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>

                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Invoice Date :<input type="date" wire:model="invoicedate" class="grow"
                            placeholder="Phone Number" />
                    </label>

                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Payment Due: <input type="date" wire:model="duedate" class="grow"
                            placeholder="Phone Number" />
                    </label>





                </div>


            </div>

        </div>

    </div>


    <br>

    @if (count($invoiceitems) > 0)


        <div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <label>
                                <input type="checkbox"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                            </label>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Code') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Name') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Size') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('QTY') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Uniy Price') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Discount(%)') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Total') }}
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <form wire:submit.prevent="save">
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($invoiceitems as $index => $stock)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">
                                <td class="px-6 py-4">
                                    <label>
                                        <input type="checkbox"
                                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $stock['itemcode'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">

                                    {{ $stock['itemname'] }}



                                </td>
                                <td>
                                    <select wire:model="invoiceitems.{{ $index }}.sizesselect"
                                        class="select select-sm select-bordered w-full max-w-xs">

                                        <option selected>Select Size</option>
                                        @foreach ($stock['sizes'] as $sizeindex => $size)
                                            @if ($size['quantity'] == 0)
                                                <option disabled value="{{ $size['size'] }}"
                                                    class="bg-red-100 text-red-700 cursor-not-allowed font-semibold">
                                                    {{ $size['size'] }} - Quantity is 0
                                                </option>
                                            @else
                                                <option value="{{ $size['size'] }}"
                                                    class="text-white-800 font-medium">
                                                    {{ $size['size'] }} - <span
                                                        class="text-blue-600 font-semibold">{{ $size['quantity'] }}
                                                        qty</span>
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>


                                </td>
                                <td class="px-6 py-4">

                                    <input type="number"
                                        wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.qty"
                                        class="w-16" />

                                </td>
                                <td class="px-6 py-4">

                                    <input type="number"
                                        wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.unitprice"
                                        class="w-24" />

                                </td>
                                <td class="px-6 py-4">

                                    <input type="text"
                                        wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.discount"
                                        class="w-24" />


                                </td>

                                <td class="px-6 py-4">

                                    {{-- <input type="text" wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.total" class="w-24" /> --}}
                                    @if ($stock['discount'] > 0)
                                        Rs.
                                        @php
                                            $itemtotal =
                                                (float) $stock['qty'] * (float) $stock['unitprice'] -
                                                ((float) $stock['qty'] *
                                                    (float) $stock['unitprice'] *
                                                    (float) $stock['discount']) /
                                                    100;
                                            $subtotal +=
                                                (float) $stock['qty'] * (float) $stock['unitprice'] -
                                                ((float) $stock['qty'] *
                                                    (float) $stock['unitprice'] *
                                                    (float) $stock['discount']) /
                                                    100;
                                        @endphp
                                        {{ $itemtotal }}
                                    @else
                                        Rs.
                                        @php
                                            $itemtotal = (float) $stock['qty'] * (float) $stock['unitprice'];
                                            $subtotal += (float) $stock['qty'] * (float) $stock['unitprice'];
                                        @endphp
                                        {{ $itemtotal }}
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-error btn-sm"
                                        wire:click="removeItem({{ $index }})">Remove</button>
                                </td>

                            </tr>
                        @endforeach
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                            <td class="px-6 py-4 " colspan="6"></td>
                            <td class="px-6 py-4">Subtotal</td>
                            <td class="px-6 py-4">{{ $subtotal }}</td>
                            <td></td>
                        </tr>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                            <td class="px-6 py-4 " colspan="6"></td>
                            <td class="px-6 py-4">Total Discount</td>
                            <td class="px-6 py-4">
                                <input type="number" wire:model.live.debounce.300ms="totaldiscount"
                                    class="w-24" />
                            </td>
                            <td></td>
                        </tr>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                            <td class="px-6 py-4 " colspan="6"></td>
                            <td class="px-6 py-4">Total Amount</td>
                            <td class="px-6 py-4">
                                @if ($totaldiscount > 0)
                                    Rs.
                                    {{ $totalAmount = (float) $subtotal - ((float) $subtotal * (float) $totaldiscount) / 100 }}
                                @else
                                    Rs.{{ $totalAmount = (float) $subtotal }}
                                @endif

                            </td>
                            <td></td>
                        </tr>
                    </tbody>
            </table>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                wire:click="save">Save</button>

        </div>
    @endif


</div>
