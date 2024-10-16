<div>


    <label class="input input-bordered flex items-center gap-2  mb-4 max-w-md">
        <input type="text" wire:model.live.debounce.300ms="search" class="grow" placeholder="Search Item Name or Code" />
      </label>

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
                    {{ __('Stock Quantity') }}
                </th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Actions') }}
                </th>
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
                            <a href="{{ route('stocks.show', $stock['id']) }}"
                            class="text-indigo-600 hover:text-indigo-900">
                            {{ $stock['name'] }}
                        </a>
                    </td>
                    
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                            @foreach ($stock['sizes'] as $sizeIndex => $size)
                            {{ $size['size'] }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                            @foreach ($stock['sizes'] as $sizeIndex => $size)
                            {{ $size['quantity'] }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                           
                            <button wire:click="deleteStock({{ $stock['id'] }})"
                                class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Delete
                                
                            </button>
                        
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>

</div>
