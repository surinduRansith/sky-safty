<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 justify-center">
        <h2 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-2
00 mb-6">
            {{ __('Stock Details') }}
        </h2>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-xl font-semibold mb-4">{{ $stock->name }} ({{ $stock->code }})</h3>

                <table class="min-w-full divide-y divide-gray-200 dark:divide
-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Size
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Quantity
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($stock->sizes as $size)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                    {{ $size->size }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                    {{ $size->quantity }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Add any other details you want to display here, like descriptions, images, etc. -->
            </div>
        </div>
    </div>
</x-app-layout>
