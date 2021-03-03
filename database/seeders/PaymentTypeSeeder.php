<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table( 'user_types' )->insert( [ 
            [
                'type_name'          => 'Cash',
            ],
            [
                'type_name'          => 'Credit card',
            ],
            
        ]);
    }
}
