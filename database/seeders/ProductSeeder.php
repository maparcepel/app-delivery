<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Product::create([
            'name'      => 'Nike Air Force',
            'category'  => 'Shoes',
            'type'      => '1',
            'desc'      => 'Normal',
            'price'     => 33.99
        ]);

        Product::create([
            'name'      => 'Vans Classic',
            'category'  => 'Shoes',
            'type'      => '1',
            'desc'      => 'Normal',
            'price'     => 63.99
        ]);
        
        Product::create([
            'name'      => 'Adidas Running',
            'category'  => 'Shoes',
            'type'      => '2',
            'desc'      => 'Delivery',
            'price'     => 53.90
        ]);

        Product::create([
            'name'      => 'Pull&Bear carrot jeans',
            'category'  => 'Jeans',
            'type'      => '1',
            'desc'      => 'Normal',
            'price'     => 53.90
        ]);
        Product::create([
            'name'      => 'ASOS DESIGN slim jeans',
            'category'  => 'Jeans',
            'type'      => '2',
            'desc'      => 'Delivery',
            'price'     => 52.90
        ]);

        
        
        

            
          
    }
}
