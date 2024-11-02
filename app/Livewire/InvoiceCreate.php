<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Size;
use App\Models\Stock;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceCreate extends Component
{

    use WithPagination;
    public $search;
    public $stock;

    public $itemdetails;
    public $itemtotal = 0;
    public $subtotal = 0;
    public $totaldiscount = 0;

    public $totalAmount = 0;


    public $invoiceitems = [];


    public $customersearch;

    public $customers;

    public $invoiceid;

    public $customerid;

    #[Rule('required')]
    public $company;

    #[Rule('required')]
    public $address;
    #[Rule('required')]
    public $invoicedate;
    #[Rule('required')]
    public $duedate;
    public $orderbills;
    public $orderitems;
    //#[Rule('required|in:30 Day Credit,COD')]
    public $paymentmethod;
    public $deliveryAddress;

    public $sizede;
    public function mount()
    {
        // Set the current date as the default for invoicedate
        $this->invoicedate = now()->format('Y-m-d');
        $this->duedate = now()->addDays(30)->format('Y-m-d');
        $this->resetserach();
    }


    public function resetserach()
    {
        $this->customersearch = '';
        $this->customers = [];

    }


    public function addItem($stockcode)
    {

        $this->stock = $stockcode;

        $this->itemdetails = Stock::findOrFail($this->stock);



        $this->invoiceitems[] = [
            'id' => $this->itemdetails->id,
            'itemcode' => $this->itemdetails->code,
            'itemname' => $this->itemdetails->name,
            'qty' => '1',
            'unitprice' => '0',
            'discount' => '0',
            'sizes' => $this->itemdetails->sizes,
            'sizesselect' => ''


        ];




    }

    public function removeItem($key)
    {

        unset($this->invoiceitems[$key]);
    }



    public function setcustomer($customerid)
    {

        $customerdetails = Customer::findOrFail($customerid);

        $this->company = $customerdetails->company;
        $this->address = $customerdetails->address;
        $this->customerid = $customerdetails->id;
        $this->deliveryAddress = $customerdetails->address;

        $this->reset('customersearch');
        $this->customers = [];

    }

    public function validateOrder()
    {
        $errors = []; // Initialize an empty array to hold error messages

        // Check if sizes are selected for each item
        foreach ($this->invoiceitems as $item) {
            if (empty($item['sizesselect'])) {
                $errors['sizesselect'] = 'Please select a size before saving the order.';
                break; // Stop the loop if one item is missing a size
            }
        }

        // Check if customer ID exists
        if (empty($this->customerid)) {
            $errors['customer'] = 'Please select a customer before saving the order.';
        }

        // Check if payment method is selected
        if (empty($this->paymentmethod)) {
            $errors['payment'] = 'Please select a payment method before saving the order.';
        }

        // Flash error messages to the session if there are any
        if (!empty($errors)) {
            session()->flash('errors', $errors);
            return false; // Stop further processing if there are errors
        }

        return true; // Validation passed, continue with order creation
    }


    public function save()
    {
        //dd($this->deliveryAddress);

        if (!$this->validateOrder()) {
            return; // Stop if validation fails
        }
        foreach ($this->invoiceitems as $item) {



            //pdf generate customer details
            $customerdetails = Customer::all()->where('id', '=', $this->customerid);


            $order = Order::create([
                'id' => $this->invoiceid,
                'customer_id' => $this->customerid,
                'invoicedate' => $this->invoicedate,
                'paymentmethod' => $this->paymentmethod,
                'duedate' => $this->duedate,
                'deliveryaddress' => $this->deliveryAddress,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($this->invoiceitems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'stock_id' => $item['id'],
                    'sizes' => $item['sizesselect'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['unitprice'],
                    'discount' => $item['discount'],
                    'total_discount' => $this->totaldiscount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);



                // Assuming $item['itemcode'] and $item['sizesselect'] are defined
                $size = Size::where('stock_id', $item['id'])
                    ->where('size', $item['sizesselect'])
                    ->first(); // Get the size record

                if ($size && $size->quantity >= $item['qty']) {
                    // Decrease quantity safely
                    $size->decrement('quantity', $item['qty']);
                } else {
                    // Handle the case where there's not enough quantity
                    session()->flash('error', 'Not enough quantity available for the selected size.');
                }

            }




            // Clear the items after saving
            $this->reset(['invoiceitems', 'company', 'address', 'customerid', 'paymentmethod']);

            session()->flash('success', 'Order saved successfully.');

            //pdf generate bill and item details
            $this->orderbills = Order::all()->where('id', '=', $this->invoiceid);
            $this->orderitems = OrderItem::where('order_id', '=', $this->invoiceid)->get();





            $data = [
                'orderbills' => $this->orderbills,
                'orderitems' => $this->orderitems,
                'customerdetails' => $customerdetails,
                'deliveryAddress' => $this->deliveryAddress
            ];

            $pdf = Pdf::loadView('orders.invoice-pdf', $data);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'invoice.pdf');
        }

    }


    public function render()
    {
        if ($this->customersearch != '') {
            $this->customers = Customer::where('name', 'like', '%' . $this->customersearch . '%')
                ->orWhere('company', 'like', '%' . $this->customersearch . '%')
                ->get()
                ->toArray();
        }


        $this->invoiceid = DB::table('orders')->max('id') + 1;

        return view('livewire.invoice-create', [
            'stocks' => Stock::latest()
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'like', '%' . $this->search . '%')
                ->paginate(3),

        ]);


    }
}
