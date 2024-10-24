<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 justify-center">
        <!-- Page Heading -->
        <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-200 mb-6">
            {{ __('Stocks') }}
        </h2>
        <div class="overflow-x-auto">
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
                            {{ __('Stock Name') }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Stock Code') }}
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
                        @foreach ($stock['sizes'] as $sizeIndex => $size)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">
                                <td class="px-6 py-4">
                                    <label>
                                        <input type="checkbox"
                                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    <a href="{{ route('stocks.show', $stock['id']) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        {{ $stock['name'] }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $stock['code'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $size['size'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                    {{ $size['quantity'] }}
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="deleteStock({{ $index }})"
                                        class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
