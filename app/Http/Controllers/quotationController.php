<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class quotationController extends Controller
{
  public function index(){
    return view('quotation.index');
  }
}
