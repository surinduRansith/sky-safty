<div>
    <div class="grid grid-cols-2 gap-4 pt-4 px-4 ">
        <div>
            <label class="input input-bordered flex items-center gap-2  mb-4 max-w-md input-md">
                <input type="text" wire:model.live.debounce.300ms="search" class="grow" placeholder="Search Item Name or Code" />
              </label>
          <br>
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
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300"></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($stocks as $index => $stock)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">
                    <td class="px-6 py-4">
                        <label>
                            <input type="checkbox"
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                {{ $stock['code'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                          
                                {{ $stock['name'] }}
                           
                        </td>
                            <td class="px-6 py-4">
                               
                                <button wire:click="addItem({{ $stock['id'] }})"
                                    class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Add
                                    
                                </button>
                            
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
      <br>
        {{$stocks->links()}}

        </div>
        <div>
            <div class="relative max-w-md">
                <label class="input input-bordered flex items-center gap-2 mb-4 input-md">
                    <input type="text" wire:model.live.debounce.300ms="customersearch" class="grow" placeholder="Search Customer" />
                </label>
            
                @if (!empty($customers))
                    <div class="absolute top-full mt-1 w-full bg-gray-100    border border-gray-300 rounded-lg shadow-lg z-10">
                        @foreach ($customers as $index => $customer)
                        <div class="px-4 py-2 dark:hover:bg-blue-400 cursor-pointer   border border-gray-300 rounded-lg shadow-lg z-10 ">
                        <button wire:click.prevent="setcustomer({{ $customer['id'] }})" class="w-full text-left">
                              <span class="dark:text-blue-900"> {{ $customer['name'] }} </span>
                            </button>
                        </div>  
                        @endforeach
                    </div>
                @endif
            </div>
            
            <div class="grid grid-cols-2 gap-4 pt-4 px-4 ">
                <div>  
                    <label class="input input-bordered flex items-center gap-2 mb-4 input-sm">
                    Invoice ID : <span class="text-white-500">{{ $invoiceid }}</span>
                  </label>
                </div>
                <div>  
                    <label class="input input-bordered flex items-center gap-2 mb-4 input-sm">
                    <input type="text" wire:model="POnumber" class="grow" placeholder="PO Number" />
                  </label>
                  @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>  
                    <label class="input input-bordered flex items-center gap-2 mb-4 input-sm">
                    <input type="text" wire:model="name" class="grow" placeholder="Customer Name" />
                  </label>
                  @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                     <label class="input input-bordered flex items-center gap-2 mb-4 input-sm">
                    <input type="text" wire:model="company" class="grow" placeholder="Company Name" />
                  </label>
                  @error('company') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-2 mb-4 input-sm">
                        <input type="text" wire:model="address" class="grow" placeholder="Company Address" />
                      </label>
                      @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-2 mb-4 input-sm">
                        <input type="text" wire:model="email" class="grow" placeholder="Customer Email" />
                      </label>
                      @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="input input-bordered flex items-center gap-2 mb-4 input-sm">
                        <input type="text" wire:model="phone" class="grow" placeholder="Phone Number" />
                      </label>
                      @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <select wire:model="paymentmethod" class="select select-sm select-bordered w-full max-w-xs">
                        <option disabled selected>Select Payment Method</option>
                        <option>Cash</option>
                        <option>Cheque</option>
                        <option>Credit</option>
                        <option>Online</option>
                      </select>
                      @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                

            </div>
        </div>

    </div>

    <div class="grid pt-4 px-4 ">
        <br>

 @if (count($invoiceitems) > 0)
     
     
<div >
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
                        <td class="px-6 py-4">
                           
                          <input type="number" wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.qty" class="w-16"  />
                        
                        </td>
                        <td class="px-6 py-4">
                            
                          <input type="number" wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.unitprice" class="w-24" />
                        
                        </td>
                        <td class="px-6 py-4">
                            
                          <input type="text" wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.discount" class="w-24" />
                          
                        
                        </td>
                       
                        <td class="px-6 py-4">

                            {{-- <input type="text" wire:model.live.debounce.300ms="invoiceitems.{{ $index }}.total" class="w-24" /> --}}
                            @if ($stock['discount'] > 0)
                         
                            @php
                                $itemtotal = ((float)$stock['qty'] * (float)$stock['unitprice']) - ((float)$stock['qty'] * (float)$stock['unitprice'] * (float)$stock['discount'] / 100);
                                $subtotal += ((float)$stock['qty'] * (float)$stock['unitprice']) - ((float)$stock['qty'] * (float)$stock['unitprice'] * (float)$stock['discount'] / 100);
                            @endphp
                            {{$itemtotal}}
                            @else
                            
                            @php
                                $itemtotal = (float)$stock['qty'] * (float)$stock['unitprice'];
                                $subtotal += (float)$stock['qty'] * (float)$stock['unitprice'];
                            @endphp
                             {{$itemtotal}}
                            @endif
                        </td>
                    </tr>
            @endforeach
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                <td class="px-6 py-4 " colspan="5"></td>
                <td class="px-6 py-4">Subtotal</td>
                <td class="px-6 py-4">{{$subtotal}}</td>
            </tr>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                <td class="px-6 py-4 " colspan="5"></td>
                <td class="px-6 py-4">Total Discount</td>
                <td class="px-6 py-4">
                <input type="number" wire:model.live.debounce.300ms="totaldiscount" class="w-24" />
                </td>
            </tr>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">

                <td class="px-6 py-4 " colspan="5"></td>
                <td class="px-6 py-4">Total Amount</td>
                <td class="px-6 py-4">
                   @if ($totaldiscount > 0)
                      
                   {{$totalAmount=(float)$subtotal - ((float)$subtotal * (float)$totaldiscount / 100)}}
                    @else
                    {{$totalAmount=(float)$subtotal}}
                    @endif
                    
                </td>
            </tr>
        </tbody>
    </table>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click="save">Save</button>
            
</div>
@endif  

    </div>
</div>