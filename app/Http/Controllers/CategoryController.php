<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function get(){
        
        $categories = Category::all();
        
        $result = [];

        foreach($categories as $value){

            $subcategories = Subcategory::where('category_id', $value->id)->get();

            $subcategories2 = [];

            foreach( $subcategories as $category){

                $category2 = array('id' => $category->id, 'Subcategory' => $category->name);
                array_push($subcategories2, $category2);
            }

            $category = ['id' => $value->id, 'category'  => $value->name, 'Subcategories' => $subcategories2];

            array_push($result, $category);
        }

        $data = array(
            'code' => 200,
            'status' => 'success',
            'message'   => $result
        );
    

        return json_encode($data);

    }    
}
