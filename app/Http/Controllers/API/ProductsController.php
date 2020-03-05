<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //
        $products = Product::all();
        if ($products === null) {
            return response()->json(['Result' => 'Data is empty'], 200);
        }
        return  response()->json(['Success' => $products], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        $request = $request->all();
        $products = new Product;
        $validate = \Illuminate\Support\Facades\Validator::make($request, $products->rules);
        if ($validate->fails()) {
            return response()->json($validate->messages()->first(), 401);
        }
        $products = Product::create($request);

        return response()->json(['Product Created' => $products], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
        $products = Product::query()->find($id);
        $request = $request->all();
//        check if id exist
        if ($products === null) {
            return response()->json(['Error' => 'Id Not Found'], 404);
        }
        Product::query()->where('id', $id)->update($request);
        return response()->json(['Data Updated' => Product::find($id)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
//        get data before deleted to show what item that deleted
        $data = [];
        array_push($data, Product::find($id));

        $products = Product::find($id);
//        check if id exist
        if ($products === null) {
            return response()->json(['Error' => 'Id Not Found'], 404);
        }
        $products->delete();
        return response()->json(['Success deleted item with data' => $data], 200);
    }
}
