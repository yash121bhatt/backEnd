<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Product;
use Illuminate\Http\Request;
use DB;
class ProductController extends Controller
{
    public function productCreate(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'price' => 'required',
			'desc' => 'string'
		]);
		if ($validator->fails()) {
			$resp = [
				'code' => 409,
				'error' => $validator->errors(),
			];
			return response($resp);
		} else {

			$saveProduct = DB::table('products')->insert([
				'name' => $request->name,
				'price' => $request->price,
				'desc' => $request->desc
			]);

			if ($saveProduct) {
				return response()->json($data = [
					'status' => 200,
					'msg' => 'Saved!!',
				]);
			} else {
				return response()->json($data = [
					'status' => 203,
					'msg' => 'something went wrong'
				]);
			}
		}
	}
    //post Api End

    function productList()
	{
		$products = DB::table('products')->get();

		if ($products->count()) {
			return response()->json($data = [
				'status' => 200,
				'msg' => 'Success',
				'data' => $products
			]);
		} else {
			return response()->json($data = [
				'status' => 201,
				'msg' => 'Data Not Found'
			]);
		}
	}

}


