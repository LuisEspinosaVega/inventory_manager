<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offices')->insert(
            [
                'name' => 'TRANSITO',
                'address' => 'SUCURSAL PARA TRANSITO',
                'contact' => 'ADMIN',
                'email' => 'lespinosa@roesga.com',
                'phone' => '3318891465'
            ]
        );
    }
}
