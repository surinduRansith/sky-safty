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

        <button  wire:click="PdfReport" class="btn btn-primary btn-sm">Show</button>

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
