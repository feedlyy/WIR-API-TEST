<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    //
    protected $table = 'sold_products';
    protected $primaryKey = 'id';

    protected $fillable = [
      'quantity'
    ];
}
