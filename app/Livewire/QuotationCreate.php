<?php

namespace App\Livewire;

use App\Models\companyDetails;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\quotation;
use App\Models\Size;
use App\Models\Stock;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class QuotationCreate extends Component
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

    public $quotatoinId;

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
    public $contactNumber = 711335922;
    public $orderitems;
    //#[Rule('required|in:30 Day Credit,COD')]
    public $paymentMethod;

    public $validperiod;

    public $quotationYear;
    public $sizede;
    public function mount()
    {
        $this->setDueDate();
        //$this->setinvoiceDate();

        // Set the current date as the default for invoicedate
        $this->invoicedate = now()->format('Y-m-d');

        $this->duedate = now()->addDays(7)->format('Y-m-d');
        $this->quotationYear = now()->format('Y');
        $this->resetserach();
        $this->quotatoinId = $this->quotationYear . "/" . DB::table('quotations')->max('id') + 1;





    }

    public function updatedinvoicedate($value)
    {
        $this->setDueDate();
    }

    public function updatedvalidperiod($value)
    {
        // Update the due date when the payment method changes
        $this->setDueDate();
    }

    private function setDueDate()
    {

        if ($this->validperiod == '7 Day') {

            $this->duedate = \Carbon\Carbon::parse($this->invoicedate)->addDays(7)->format('Y-m-d');


        } elseif ($this->validperiod == '14 Day') {
            $this->duedate = \Carbon\Carbon::parse($this->invoicedate)->addDays(14)->format('Y-m-d');
        }
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
            'description' => $this->itemdetails->description,
            'image' => $this->itemdetails->image,
            'itemname' => $this->itemdetails->name,
            'qty' => '1',
            'unitprice' => '0',
            'discount' => '0',
            'sizes' => $this->itemdetails->sizes,



        ];




    }

    public function removeItem($key)
    {

        unset($this->invoiceitems[$key]);
        $this->invoiceitems = array_values($this->invoiceitems);

    }



    public function setcustomer($customerid)
    {

        $customerdetails = Customer::findOrFail($customerid);

        $this->company = $customerdetails->company;
        $this->address = $customerdetails->address;
        $this->customerid = $customerdetails->id;

        $this->reset('customersearch');
        $this->customers = [];

    }

    public function validateOrder()
    {
        $errors = []; // Initialize an empty array to hold error messages



        // Check if customer ID exists
        if (empty($this->customerid)) {
            $errors['customer'] = 'Please select a customer before saving the quotation.';
        }

        // Check if payment method is selected
        if ($this->paymentMethod == 'Payment Method') {
            $errors['paymentMethod'] = 'Please select a payment method before saving the quotation.';
        }

        if ($this->validperiod == 'Select Valid Period') {
            $errors['validperiod'] = 'Please select a valid period before saving the quotation.';
        }

        foreach ($this->invoiceitems as $item) {
            if ($item['unitprice'] < 0) {
                $errors['unitprice'] = 'Unit Price cannot be negative before saving the quotation.';
            }
            if ($item['qty'] < 0) {
                $errors['qty'] = 'Quantity cannot be negative before saving the quotation.';
            }
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

        // if($this->paymentMethod == '30 Day Credit'){
        //     $this->duedate = now()->addDays(30)->format('Y-m-d');
        // }elseif($this->paymentMethod == 'COD'){
        //     $this->duedate = now()->addDays(1)->format('Y-m-d');

        // }


        if (!$this->validateOrder()) {
            return;
        }






        //pdf generate customer details
        $customerdetails = Customer::all()->where('id', '=', $this->customerid);



        $qutation = quotation::create([
            'code' => $this->quotatoinId,
        ]);


        // Clear the items after saving
        //$this->reset(['invoiceitems', 'company', 'address', 'customerid', 'paymentmethod']);

        session()->flash('success', 'Quotation saved successfully.');

        //pdf generate bill and item details
        $this->orderbills = quotation::where('code', '=', $this->quotatoinId)->get();
        $this->orderitems = OrderItem::where('order_id', '=', $this->quotatoinId)->get();

        $companydetails = companyDetails::all()->first(); 




        $data = [
            'quotationitems' => $this->invoiceitems,
            'code' => $this->quotatoinId,
            'quoteDate' => $this->invoicedate,
            'dueDate' => $this->duedate,
            'paymentMethod' => $this->paymentMethod,
            'validityPeriod' => $this->validperiod,
            'orderitems' => $this->orderitems,
            'customerdetails' => $customerdetails,
            'contactNumber' => $this->contactNumber,
            'companydetails'=>$companydetails,

        ];

        $pdf = Pdf::loadView('quotation.quotationPdf', $data)
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Quote.pdf');


    }
    public function render()
    {
        if ($this->customersearch != '') {
            $this->customers = Customer::where('name', 'like', '%' . $this->customersearch . '%')
                ->orWhere('company', 'like', '%' . $this->customersearch . '%')
                ->get()
                ->toArray();
        }



        return view('livewire.quotation-create', [
            'stocks' => Stock::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'like', '%' . $this->search . '%')
                ->orderBy('code', 'asc')
                ->paginate(3),
        ]);
    }
}
