<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Subcategory;;



class ProductController extends Controller
{
    public function get( Request $request ){
      
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        //Filtrar por tipo de producto
        $products = Product::where(['product_type_id' => $params_array['product_type_id']])->get();

        //Filtrar por subcategorías y por categorías que están en el listado, pero no están asociadas a estas subcategorías
        $subcategory_ids = [];
        if(!is_null($params_array['subcategory_ids'])){

            $subcategory_ids = explode(',', $params_array['subcategory_ids']);
        }

        if(!is_null($params_array['category_ids'])){

            //Obtener categorías 
            $categories = Subcategory::whereIn('id', $subcategory_ids)->get('category_id');

            
            echo $categories ;die();

            $category_ids = explode(',', $params_array['category_ids']);



        }

        $products = $products->whereIn('subcategory_id', $subcategory_ids);

        return json_encode($products);
    }
}
