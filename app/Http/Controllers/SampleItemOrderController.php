<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleItemOrderController extends Controller
{
      public function index()
    {
        return view('sampleItemOrder.index');
    }
}
