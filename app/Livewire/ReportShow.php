<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportShow extends Component
{
    public $reports =[];
    public $startDateReport;
    public $endDateReport;

    public    $noDataFound;

    public $orderbills;

    public $orderitems;
  

    public function mount(){
        
        $this->startDateReport = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDateReport = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function Show(){

        $this->reports = OrderItem::select(
            'order_items.order_id',
            'order_items.created_at',
            DB::raw('SUM(
                    CASE 
                        WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price) - (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
                        ELSE order_items.quantity * order_items.unit_price
                    END
                ) as total_amount'),
            DB::raw('SUM(
                    CASE 
                        WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
                        ELSE 0
                    END
                ) as total_discount'),
            DB::raw('SUM(
                    CASE 
                        WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price) - (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
                        ELSE order_items.quantity * order_items.unit_price
                    END
                ) - 
                SUM(
                    CASE 
                        WHEN order_items.total_discount > 0 THEN (order_items.quantity * order_items.unit_price * order_items.total_discount / 100) 
                        ELSE 0
                    END
                ) as final_total'),
            'orders.invoicedate'
        )
        ->join('orders', 'orders.id', '=', 'order_items.order_id')  // Join orders table with order_items
        ->whereBetween('order_items.created_at', [$this->startDateReport, $this->endDateReport])
        ->groupBy('order_items.order_id', 'orders.invoicedate')  // Group by order_id and invoicedate
        ->get();
    
    
        if ($this->reports->isEmpty()) {
            $this->noDataFound = true;
        } else {
            $this->noDataFound = false;
        }
    
    }

    public function PdfReport(){

        $this->reports = OrderItem::select(
            'order_items.order_id',
            'order_items.created_at',
            DB::raw('SUM(
                    CASE 
                        WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price) - (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
                        ELSE order_items.quantity * order_items.unit_price
                    END
                ) as total_amount'),
            DB::raw('SUM(
                    CASE 
                        WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
                        ELSE 0
                    END
                ) as total_discount'),
            DB::raw('SUM(
                    CASE 
                        WHEN order_items.discount > 0 THEN (order_items.quantity * order_items.unit_price) - (order_items.quantity * order_items.unit_price * order_items.discount / 100) 
                        ELSE order_items.quantity * order_items.unit_price
                    END
                ) - 
                SUM(
                    CASE 
                        WHEN order_items.total_discount > 0 THEN (order_items.quantity * order_items.unit_price * order_items.total_discount / 100) 
                        ELSE 0
                    END
                ) as final_total'),
            'orders.invoicedate'
        )
        ->join('orders', 'orders.id', '=', 'order_items.order_id')  // Join orders table with order_items
        ->whereBetween('order_items.created_at', [$this->startDateReport, $this->endDateReport])
        ->groupBy('order_items.order_id', 'orders.invoicedate')  // Group by order_id and invoicedate
        ->get();

        

        $data=[
            'reports'=>$this->reports,
            'startDateReport'=>$this->startDateReport,
            'endDateReport'=>$this->endDateReport,

       
       ];

       $pdf=Pdf::loadView('reports.reportpdf',$data);

       return response()->streamDownload(function() use($pdf){
           echo $pdf->stream();
       },'report.pdf');
    }


    public function save($order_id)
    {
       
        $this->orderbills= Order::where('id','=',$order_id)->get();
        $this->orderitems = OrderItem::where('order_id', '=', $order_id)->get();
     
        foreach ($this->orderbills as $orderbill) {
            
            $customer_id= $orderbill['customer_id'];
            $deliveryaddress = $orderbill['deliveryaddress'];
        }
        
        $customerdetails = Customer::where('id','=',$customer_id)->get();
        
        
    
        $data=[
             'orderbills'=>$this->orderbills,
             'orderitems'=>$this->orderitems,
            'customerdetails'=>$customerdetails,
            'deliveryAddress'=>$deliveryaddress
        ];

       
        $pdf=Pdf::loadView('orders.invoice-pdf',$data)
        ->setPaper('a4', 'portrait');
        

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        },'invoice.pdf');
    }
    

    public function render()
    {
        return view('livewire.report-show');
    }
}
