<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    protected $fillable = ['name', 'phone', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
