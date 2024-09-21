<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable = ['quantity', 'size', 'stock_id'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
