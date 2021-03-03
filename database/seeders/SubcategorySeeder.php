<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'subcategories' )->insert( [ 
            [
                'name'          => 'T-Shirts',
                'category_id'   => 1
            ],
            [
                'name'          => 'Tank Tops',
                'category_id'   => 1
            ],
            [
                'name'          => 'Polos',
                'category_id'   => 1
            ],
            [
                'name'          => 'Henleys',
                'category_id'   => 1
            ],
            [
                'name'          => 'Pullovers',
                'category_id'   => 2
            ],
            [
                'name'          => 'Cardigans',
                'category_id'   => 2
            ],
            [
                'name'          => 'Vests',
                'category_id'   => 2
            ],
            [
                'name'          => 'Skinny jeans',
                'category_id'   => 3
            ],
            [
                'name'          => 'Slim jeans',
                'category_id'   => 3
            ],
            [
                'name'          => 'Straight jeans',
                'category_id'   => 3
            ],
            [
                'name'          => 'Dress',
                'category_id'   => 4
            ],
            [
                'name'          => 'Casual',
                'category_id'   => 4
            ],
            [ 
                'name'          => 'Cargo',
                'category_id'   => 5
            ],
            [
                'name'          => 'Denim',
                'category_id'   => 5
            ],
            [
                'name'          => 'Flat front',
                'category_id'   => 5
            ],
            [
                'name'          => 'Pleated',
                'category_id'   => 5
            ],
            [
                'name'          => 'Bikinis',
                'category_id'   => 6
            ],
            [ 
                'name'          => 'Boxer briefs',
                'category_id'   => 6
            ],
            [
                'name'          => 'Boxers',
                'category_id'   => 6
            ],
            [
                'name'          => 'Briefs',
                'category_id'   => 6
            ],
            [
                'name'          => 'Shapewear',
                'category_id'   => 6
            ],
            
        ]);
    }
}
