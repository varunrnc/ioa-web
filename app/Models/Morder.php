<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Morder extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(OrderedItem::class,  'orderid', 'orderid');
    }
    public function address()
    {
        return $this->hasOne(Address::class,  'id', 'address_id');
    }


    public function plant()
    {

        return $this->hasManyThrough(Plant::class, OrderedItem::class, 'orderid', 'pid', 'orderid', 'pid');
    }
}
