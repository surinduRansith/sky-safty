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
                          
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                                {{ $stock['code'] }}
                            </td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                                {{ $stock['name'] }}
                            </td>
                            <td class="px-4 py-2">
                                <button wire:click="addItem({{ $stock['id'] }})"
                                    class="rounded-full inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.2502 6C11.2502 5.58579 11.586 5.25 12.0002 5.25C12.4145 5.25 12.7502 5.58579 12.7502 6V11.2502H18.0007C18.4149 11.2502 18.7507 11.586 18.7507 12.0002C18.7507 12.4145 18.4149 12.7502 18.0007 12.7502H12.7502V18.0007C12.7502 18.4149 12.4145 18.7507 12.0002 18.7507C11.586 18.7507 11.2502 18.4149 11.2502 18.0007V12.7502H6C5.58579 12.7502 5.25 12.4145 5.25 12.0002C5.25 11.586 5.58579 11.2502 6 11.2502H11.2502V6Z" fill="#FFFFFF"/>
                                        </svg>
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
                    <div role="alert" class="alert alert-error mb-4 p-2 text-sm" x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 5000)" x-show="show">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 stroke-current" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-2 text-gray">{{ $error }}</span>
                    </div>
                @endforeach
            @endif



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




            <div class="grid grid-cols-2 gap-4 pt-1 px-4 ">
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Quotation No : <span class="text-white-500">{{ $quotatoinId }}</span>
                    </label>
                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        <input type="text" wire:model="company" class="grow" placeholder="Company Name" />
                    </label>
                    @error('company')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        <input type="text" wire:model="address" class="grow" placeholder="Company Address" />
                    </label>
                    @error('address')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <select wire:model="paymentMethod" class="select select-sm select-bordered w-full max-w-xs">
                        <option selected>Payment Method</option>
                        <option value="30 Day Credit">30 Day Credit </option>
                        <option value="COD">COD</option>

                    </select>
                    @error('paymentMethod')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <select wire:model.live="validperiod" class="select select-sm select-bordered w-full max-w-xs">
                        <option selected>Select Valid Period</option>
                        <option value="7 Day">7 Day </option>
                        <option value="14 Day">14 Day</option>

                    </select>
                    @error('validperiod')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>

                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Quotation Date :<input type="date" wire:model.live="invoicedate" class="grow"
                            placeholder="Phone Number" />
                    </label>

                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                        Payment Due: <input type="date" disabled  wire:model.live="duedate" class="grow"
                            placeholder="due date" />
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
                        
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Code') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Name') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('QTY') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Unit Price') }}
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
                               
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $stock['itemcode'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">

                                    {{ $stock['itemname'] }}



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
                                    <button class=" rounded-full btn btn-error btn-sm"
                                        wire:click="removeItem({{ $index }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                          </svg>
                                            
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                            <td class="px-6 py-4 " colspan="4"></td>
                            <td class="px-6 py-4">Subtotal</td>
                            <td class="px-6 py-4">{{ $subtotal }}</td>
                            <td></td>
                        </tr>

                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                            <td class="px-6 py-4 " colspan="4"></td>
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
            <br>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" wire:click="save">
                 Create Quotation
                <span class="loading loading-spinner text-primary" wire:loading></span>
            </button>

        </div>
    @endif


</div>
