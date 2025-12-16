<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sampleorderitems extends Model
{
     protected $fillable = [
        'order_id',
        'stock_id',
        'sizes',
        'quantity',
    ];
       
     public function sampleorder()
    {
        return $this->belongsTo(sampleorder::class);
    }
     public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
