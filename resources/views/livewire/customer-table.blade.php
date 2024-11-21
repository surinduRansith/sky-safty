<div>
    <label class="input input-bordered flex items-center gap-2 mb-4 max-w-md  ">
        <input type="text" wire:model.live.debounce.300ms="search" class="grow"
            placeholder="Customer Name Or Company" />
    </label>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
               
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Customer Name') }}
                </th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Company Name') }}
                </th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Company Address') }}
                </th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Customer Email') }}
                </th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Phone Number') }}
                </th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                   
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($customers as $index => $customer)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition ease-in-out duration-150">
                    
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                        <a href="{{ route('customers.show', $customer['id']) }}"
                            class="text-indigo-600 hover:text-indigo-900">
                            {{ $customer['name'] }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                        {{ $customer['company'] }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                        {{ $customer['address'] }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                        {{ $customer['email'] }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                        {{ $customer['phone'] }}
                    </td>
                    <td class="px-6 py-4">
                                            <button onclick="my_modal_1{{ $customer['id'] }}.showModal()"
                        class="rounded-full inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>

                    </button>
                    <dialog id="my_modal_1{{ $customer['id'] }}" class="modal">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Do you want to Delete</h3>
                            <p class="py-4">{{ $customer['company'] }} is going to be deleted</p>
                            <div class="modal-action justify-center">
                                <form method="dialog">
                                    <!-- if there is a button in form, it will close the modal -->
                                    <button wire:click="deleteCustomer({{ $customer['id'] }})"
                                        class="btn btn-error pl-4">
                                        Yes

                                    </button>
                                    <button class="btn btn-primary">No</button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                    
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    {{ $customers->links() }}
</div>
