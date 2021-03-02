<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function get($categodyId = false){
        if($categodyId){

            $products = Product::where(['type' => $categodyId])->get();

        }else{

            $products = Product::All();

        }
        
       return json_encode($products);
    }
}
