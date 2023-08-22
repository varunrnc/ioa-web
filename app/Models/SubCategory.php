<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public function img()
    {
        return $this->hasOne(SubCategoryImg::class, 'sub_cat_id', 'id')->where('type', 'md');
    }

    public function imgmd()
    {
        return $this->hasMany(SubCategoryImg::class, 'sub_cat_id', 'id')->where('type', 'md');
    }

    public function imglg()
    {
        return $this->hasMany(SubCategoryImg::class, 'sub_cat_id', 'id')->where('type', 'lg');
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'pid', 'id');
    }
}
