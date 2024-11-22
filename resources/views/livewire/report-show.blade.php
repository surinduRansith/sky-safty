<div>
    @if (session('success'))
    <div role="alert" class="alert alert-success mb-4 p-2 text-sm" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)"
        x-show="show">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}done</span>
    </div>
@endif
    <div class="grid grid-cols-4 gap-4 ">
        <div>
            <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                Start Date :<input type="date" wire:model="startDateReport" class="grow"
                     />
            </label>
        </div>
        <div>
         
            <label class="input input-bordered flex items-center gap-1 mb-1 input-sm">
                End Date :<input type="date" wire:model="endDateReport" class="grow"
                     />
            </label>
        </div>
        <div>
            <button  wire:click="Show" class="btn btn-primary btn-sm">Show</button>
            
        </div>
        <label class="input input-bordered flex items-center gap-2  mb-4 max-w-md input-sm">
            <input type="text" wire:model.live.debounce.300ms="search" class="grow"
                placeholder="Search Invoice Number Or Company" />
        </label>
       
    </div>
    
    <div class="overflow-x-auto mt-4">
       
       @if(count($reports)>0)

       <div>

        <button  wire:click="PdfReport" class="btn btn-primary btn-sm ">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#343C54" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.8923 16.7332C16.8923 17.9759 15.885 18.9832 14.6423 18.9832H6.34375C5.10111 18.9832 4.09375 17.9759 4.09375 16.7332V8.60187C4.09375 8.00538 4.33061 7.4333 4.75226 7.01138L9.10142 2.65951C9.52341 2.23725 10.0959 2 10.6929 2H14.6423C15.885 2 16.8923 3.00736 16.8923 4.25V16.7332ZM14.6423 17.4832C15.0566 17.4832 15.3923 17.1475 15.3923 16.7332V4.25C15.3923 3.83579 15.0565 3.5 14.6423 3.5H10.8227L10.8249 6.47969C10.8257 7.72296 9.81813 8.73129 8.57486 8.73129H5.59375V16.7332C5.59375 17.1475 5.92954 17.4832 6.34375 17.4832H14.6423ZM6.65314 7.23129L9.32349 4.55928L9.32486 6.48076C9.32516 6.89518 8.98928 7.23129 8.57486 7.23129H6.65314Z" fill="#343C54"/>
                <path d="M18.4065 5.68442C18.4065 5.27021 18.7423 4.93442 19.1565 4.93442C19.5707 4.93442 19.9065 5.27021 19.9065 5.68442V17.2514C19.9065 19.8747 17.7799 22.0014 15.1565 22.0014H7.79765C7.38344 22.0014 7.04765 21.6656 7.04765 21.2514C7.04765 20.8371 7.38344 20.5014 7.79765 20.5014H15.1565C16.9514 20.5014 18.4065 19.0463 18.4065 17.2514V5.68442Z" fill="#343C54"/>
                </svg>
                
              Download Report
            <span class="loading loading-spinner text-error" wire:loading></span>
        
        </button>

       </div>

       <table class="table table-zebra min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300" >Order ID</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300" >Company</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300" >Invoice Date</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300" >Final Total</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300" ></th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @php
                $total = 0;
            @endphp
            @foreach ($reports as $report)

                   
                <tr>
                    <td  >SS/{{ $report->order_id }}</td>
                   <td  > {{ $report->company}}</td>
                    <td  >
                        {{ $report->invoicedate }}
                    </td>
                    <td   >Rs. {{ number_format($report->final_total, 2) }}</td>
                    <td class="w-40">
                        <button  class="rounded-full inline-flex items-center px-3 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"

                         wire:click="save({{ $report->order_id }})">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                         stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          </svg>
                          
                        </button>
                        
                        <button onclick="my_modal_1{{ $report->order_id  }}.showModal()"
                        class="rounded-full inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>

                    </button>
                    <dialog id="my_modal_1{{ $report->order_id  }}" class="modal">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Do you want to Delete</h3>
                            <p class="py-4">SS/{{ $report->order_id  }} is going to be deleted</p>
                            <div class="modal-action justify-center">
                                <form method="dialog">
                                    <!-- if there is a button in form, it will close the modal -->
                                    <button wire:click="deleteinvoice({{ $report->order_id  }})"
                                        class="btn btn-error pl-4">
                                        Yes

                                    </button>
                                    <button class="btn btn-primary">No</button>
                                </form>
                            </div>
                        </div>
                    </dialog>

                    
                    </td>
                    @php
                        $total += $report->final_total;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td  colspan="2">Total</td>
                <td >Rs. {{ number_format($total, 2) }}</td>
                <td  ></td>
            </tr>
        </tbody>
    </table>
    @else

   
    
    @endif
        
      
    </div>
</div>
