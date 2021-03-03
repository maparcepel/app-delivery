<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
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
                'type_name'          => 'Admin',
            ],
            [
                'type_name'          => 'Customer',
            ],
            
        ]);
    }
}
