<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class companyDetails extends Model
{
    protected $table = 'company_details';

    protected $fillable = [
        'company_name',
        'address',
        'phone_number',
        'email',
        'website',
        'logo',
        'brregistration',
    ];
}
