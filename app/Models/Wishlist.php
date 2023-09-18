<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public function plant()
    {
        return $this->hasOne(Plant::class, 'pid', 'pid');
    }
    public function img()
    {
        return $this->hasOne(PlantImg::class, 'pid', 'pid')->where('type', 'md');
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'pid', 'pid');
    }
}
