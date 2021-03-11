<?php

//Coded by Marcel Molina

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;



class ProductController extends Controller
{
    public function get( Request $request ){
      
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(($params_array['product_type_id'] != 1 && $params_array['product_type_id'] != 2) || empty($params_array['product_type_id'])){
            $data = array(
                'status'    => 'error',
                'code'      => 400,
                'message'   => 'El valor <product_type_id> no es correcto',
            );
        }else{  
            //Filtrar por tipo de producto

            $products = Product::where(['product_type_id' => $params_array['product_type_id']])->get();

            //Filtrar por subcategorías y por categorías que están en el listado, pero no están asociadas a estas subcategorías
        
            $subcategory_ids = [];

            if(!is_null($params_array['subcategory_ids'])){

                //Validar subcategory_ids
                
                    $subcategory_ids = explode(',', $params_array['subcategory_ids']);
                
            }

            if(!is_null($params_array['category_ids'])){
                
                //Obtener categorías a las que pertenecen las subcategorías pasadas

                $categories = Subcategory::whereIn('id', $subcategory_ids)->get('category_id')->toArray();

                $categories2 = [];
                foreach($categories as $key => $value){
                    
                    array_push($categories2, (string)$value['category_id']);
                    
                }
                
                //Obtener array categorías pasadas

                $category_ids = collect(explode(',', $params_array['category_ids']));

                //En las categorías pasadas eliminar las que están vinculadas a las subcategorías

                $category_diff = $category_ids->diff($categories2);
                
            }

            $products1 = $products->whereIn('subcategory_id',  $subcategory_ids);
            $products2 = $products->whereIn('category_id',  $category_diff);

            $products = $products1->merge($products2);

            $products =  $products->map(function ($item, $key) {

                return collect($item)->except(['created_at', 'updated_at'])->toArray();
                
            });

            $data = array(
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Se han encontrado ' . $products->count() . ' productos',
                'Pedidos'   => $products
            );   
        }

        return json_encode($data);
    }

    public function search( Request $request ){
      
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if( empty($params_array['product_type_id'] )){

            $data = array(
                'status'    => 'error',
                'code'      => 400,
                'message'   => 'El valor <product_type_id> no es correcto',
            );

        }elseif( empty($params_array['text']) ){

            $data = array(
                'status'    => 'error',
                'code'      => 400,
                'message'   => 'Debe incluir un texto para buscar',
            );

        }else{  
            echo $params_array['product_type_id'];

            $search = $params_array['text'];

            $products = Product::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->get();

                $products = $products->where('product_type_id', $params_array['product_type_id']);

                $products =  $products->map(function ($item, $key) {

                    return collect($item)->except(['created_at', 'updated_at']);
                    
                });

            $data = array(
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'Se han encontrado ' . $products->count() . ' productos',
                'productos' => $products->values()
            );
        }

        return json_encode($data);
    }

}
