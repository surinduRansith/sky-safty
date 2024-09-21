<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'image', 'description'];

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
