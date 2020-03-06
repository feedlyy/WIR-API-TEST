<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use App\SoldProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function buy (Request $request, $item)
    {
        $this->authorize('Costumer', User::class);

//        find item
        $products = Product::find($item);
        $request = $request->all();

        $validate = Validator::make($request, [
           'total' => 'required|integer'
        ]);

        //validate input
        if ($validate->fails()) {
            return response()->json($validate->messages()->first(), 401);
        }

//        check if item its not found
        if ($products === null) {
            return response()->json(['Error' => 'Item Not Found'], 404);
        }

//        check if product stock is enought to buy
        if ($products->stock - $request[array_key_first($request)] < 0) {
            return response()->json(['Error' => 'Item stock not enough to buy'], 406);
        }

//        check if user balance is enought to buy item
        $total = $request[array_key_first($request)] * $products->price;
        if ($total > Auth::user()->balance) {
            return response()->json(['Error' => 'Your balance not enough to buy this item'], 406);
        }

        //update product after costumer bought it
        Product::query()->where('id', $item)->update([
            'stock' => $products->stock -= $request[array_key_first($request)]
        ]);

        //        create sold_products record
        SoldProduct::create([
            'id_product' => $item,
            'id_user' => Auth::id(),
            'quantity' => (int)$request[array_key_first($request)],
        ]);

        /*rules :
        if costumer bought an item, will get a reward :
        1. if < 20.000, costumer will get 5 point
        2. if >= 20.000 && < 40.000, costumer will get Reward A (20 point)
        3. if >= 40.000, costumer will get Reward B (40 point)*/

//        calculate reward
        $reward = 0;
        if ($total < 20000) {
            $reward = 5;
        } elseif ($total >= 20000 && $total < 40000) {
            $reward = 20;
        } else {
            $reward = 40;
        }

//        update user balance
        $user = Auth::user();
        User::query()->where('id', Auth::id())->update([
           'balance' => $user->balance -= $total,
            'point' => $user->point += $reward
        ]);

        return response()->json([
            'Message' => 'Transaction Success',
            'Detail' => [
                'name' => $products->name,
                'total price' => $total
            ],
            'Reward' => 'You got ' . $reward . ' point',
            'Your balance now' => Auth::user()->balance,
            'Your point now' => Auth::user()->point
        ], 200);
    }

    public function TransactionRecord ()
    {
        $this->authorize('Merchant', User::class);

        $record = SoldProduct::all();


        if ($record === null) {
            return response()->json(['Result' => 'Data is empty'], 200);
        }
        return  response()->json([
            'Message' => 'Success',
            'Transaction Record' => [
                $record
            ]
        ], 200);
    }
}
