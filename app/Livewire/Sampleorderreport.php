<?php

namespace App\Livewire;

use App\Models\companyDetails;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\sampleorder;
use App\Models\sampleorderitems;
use App\Models\Size;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sampleorderreport extends Component
{

    public $reports = [];
    public $search;
    public $startDateReport;
    public $endDateReport;

    public $noDataFound;

    public $orderbills;

    public $orderitems;


    public function mount()
    {

        $this->startDateReport = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDateReport = Carbon::now()->endOfMonth()->format('Y-m-d');

    }

    public function Show()
    {

        //     $this->reports = OrderItem::select(
        //         'order_items.order_id',
        //         'customers.company',
        //         'order_items.created_at',
        //         DB::raw('SUM(
        //                 CASE 
        //                     WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price) - (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
        //                     ELSE order_items.quantity * order_items.unit_price
        //                 END
        //             ) as total_amount'),
        //         DB::raw('SUM(
        //                 CASE 
        //                     WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
        //                     ELSE 0
        //                 END
        //             ) as total_discount'),
        //         DB::raw('SUM(
        //                 CASE 
        //                     WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price) - (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
        //                     ELSE order_items.quantity * order_items.unit_price
        //                 END
        //             ) - 
        //             SUM(
        //                 CASE 
        //                     WHEN order_items.total_discount > 0 THEN (order_items.quantity * order_items.unit_price * order_items.total_discount / 100) 
        //                     ELSE 0
        //                 END
        //             ) as final_total'),
        //         'orders.invoicedate'
        //     )
        //     ->join('orders', 'orders.id', '=', 'order_items.order_id')  // Join orders table with order_items
        //    ->join('customers', 'customers.id', '=', 'orders.customer_id')
        //     ->whereBetween('order_items.created_at', [$this->startDateReport, $this->endDateReport])
        //     ->where(function ($query) {
        //         $query->where('order_items.order_id', 'like', $this->search . '%')
        //               ->orWhere('customers.company', 'like', '%' . $this->search . '%');
        //     })
        //     ->groupBy('order_items.order_id', 'orders.invoicedate')  // Group by order_id and invoicedate
        //     ->get();

        //     if ($this->reports->isEmpty()) {
        //         $this->noDataFound = true;
        //     } else {
        //         $this->noDataFound = false;
        //     }
        $this->reports = sampleorder::select(
            'sampleorders.id',
        'sampleorders.invoicedate', 
        'customers.company')
            ->join('customers', 'customers.id', '=', 'sampleorders.customer_id')
            ->whereBetween('sampleorders.created_at', [$this->startDateReport, $this->endDateReport])
            ->where(function ($query) {
                $query->where('sampleorders.id', 'like', '%' . $this->search. '%')->orWhere('customers.company', 'like', '%' . $this->search . '%'); })
                ->orderBy('sampleorders.id', 'desc')
            ->get();
        //dd( $this->search);
        //dd($this->reports);
    }


    public function deleteinvoice($id)
    {

        $orderitems = sampleorderitems::where('order_id', '=', $id)->get();
        //dd($orderitems);
        if (!$orderitems->isEmpty()) {
            foreach ($orderitems as $index => $orderitem) {
                Size::where('stock_id', '=', $orderitem['stock_id'])  // Match size by its ID
                    ->where('size', '=', $orderitem['sizes'])  // Match the size identifier
                    ->increment('quantity', $orderitem['quantity']);  // Increment the quantity by the order item's quantity
            }
            sampleorder::where('id', '=', $id)->delete();
            session()->flash('success', 'Sample Invoice deleted successfully.');
        } else {
            dd('no');
        }
        // Order::where('id','=',$id)->delete();


    }

    public function save($id)
    {
        //dd($id);
        $this->orderbills = sampleorder::where('id', '=', $id)->get();
        $this->orderitems = sampleorderitems::where('id', '=', $id)->get();
        $companydetails = companyDetails::all()->first();

        foreach ($this->orderbills as $orderbill) {

            $customer_id = $orderbill['customer_id'];
            $deliveryaddress = $orderbill['deliveryaddress'];
        }

        $customerdetails = Customer::where('id', '=', $customer_id)->get();



        $data = [
            'orderbills' => $this->orderbills,
            'orderitems' => $this->orderitems,
            'customerdetails' => $customerdetails,
            'deliveryAddress' => $deliveryaddress,
            'companydetails' => $companydetails,
        ];


        $pdf = Pdf::loadView('sampleItemOrder.sampleorderpdf', $data)
            ->setPaper('letter', 'portrait');


        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'sampleitemorder.pdf');
    }

    public function render()
    {
        $this->Show();
        return view('livewire.sampleorderreport');
    }
}
