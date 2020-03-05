<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'stock', 'price'
    ];

    public $rules = [ //validation input
        'name' => 'required|string',
        'stock' => 'required|integer',
        'price' => 'required|integer'
    ];
}




