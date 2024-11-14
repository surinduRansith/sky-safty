<div>
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
    </div>
    <div class="overflow-x-auto mt-4">
       
       @if(count($reports)>0)

       <div>

        <button  wire:click="PdfReport" class="btn btn-error btn-sm ">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#343C54" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.8923 16.7332C16.8923 17.9759 15.885 18.9832 14.6423 18.9832H6.34375C5.10111 18.9832 4.09375 17.9759 4.09375 16.7332V8.60187C4.09375 8.00538 4.33061 7.4333 4.75226 7.01138L9.10142 2.65951C9.52341 2.23725 10.0959 2 10.6929 2H14.6423C15.885 2 16.8923 3.00736 16.8923 4.25V16.7332ZM14.6423 17.4832C15.0566 17.4832 15.3923 17.1475 15.3923 16.7332V4.25C15.3923 3.83579 15.0565 3.5 14.6423 3.5H10.8227L10.8249 6.47969C10.8257 7.72296 9.81813 8.73129 8.57486 8.73129H5.59375V16.7332C5.59375 17.1475 5.92954 17.4832 6.34375 17.4832H14.6423ZM6.65314 7.23129L9.32349 4.55928L9.32486 6.48076C9.32516 6.89518 8.98928 7.23129 8.57486 7.23129H6.65314Z" fill="#343C54"/>
                <path d="M18.4065 5.68442C18.4065 5.27021 18.7423 4.93442 19.1565 4.93442C19.5707 4.93442 19.9065 5.27021 19.9065 5.68442V17.2514C19.9065 19.8747 17.7799 22.0014 15.1565 22.0014H7.79765C7.38344 22.0014 7.04765 21.6656 7.04765 21.2514C7.04765 20.8371 7.38344 20.5014 7.79765 20.5014H15.1565C16.9514 20.5014 18.4065 19.0463 18.4065 17.2514V5.68442Z" fill="#343C54"/>
                </svg>
                
              Download
            <span class="loading loading-spinner text-primary" wire:loading></span>
        
        </button>

       </div>

       <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
        <thead>
            <tr>
                <th class="border px-4 py-2">Order ID</th>
                <th class="border px-4 py-2">Invoice Date</th>
                <th class="border px-4 py-2">Final Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($reports as $report)
                <tr>
                    <td class="border px-4 py-2">SS/{{ $report->order_id }}</td>
                    <td class="border px-4 py-2">
                        {{ $report->invoicedate }}
                    </td>
                    <td class="border px-4 py-2">Rs. {{ number_format($report->final_total, 2) }}</td>
                    @php
                        $total += $report->final_total;
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td class="border px-4 py-2 font-bold" colspan="2">Total</td>
                <td class="border px-4 py-2 font-bold">Rs. {{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @else

   
    
    @endif
        
      
    </div>
</div>
