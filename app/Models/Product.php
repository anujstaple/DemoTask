<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    
    protected $table ='products';

    protected $fillable = ['name','description','image','price','total_qty','status'];



     public function assignproduct(){
     return $this->belongsTo('App\Models\UserProduct','id','product_id');
  }
}
