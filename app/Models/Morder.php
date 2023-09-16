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
    public function plant()
    {
        return $this->hasManyThrough(Plant::class, OrderedItem::class,  'orderid', 'pid', 'id', 'id');
    }
}
