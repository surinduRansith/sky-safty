<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sampleorder extends Model
{
    protected $fillable = [
        'invoicedate',
        'customer_id'
    ];
     public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sampleorderitems()
    {
        return $this->hasMany(sampleorderitems::class);
    }
}
