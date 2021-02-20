<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert(
            [
                [
                    'name' => 'ADMINISTRADOR',
                    'description' => 'ROL PARA ADMINISTRADOR',
                    'main_admin' =>1,
                    'main_inventory'=>1,
                    'edit_inventory'=>1,
                    'main_rh'=>1,
                    'edit_rh'=>1,
                    'main_finance'=>1,
                    'edit_finance'=>1,
                    'main_social'=>1,
                    'edit_social'=>1
                ],
                [
                    'name' => 'USER DEFAULT',
                    'description' => 'ROL DEFAULT USUARIOS',
                    'main_admin' =>0,
                    'main_inventory'=>1,
                    'edit_inventory'=>0,
                    'main_rh'=>1,
                    'edit_rh'=>0,
                    'main_finance'=>1,
                    'edit_finance'=>0,
                    'main_social'=>1,
                    'edit_social'=>0
                ]
            ]
        );
    }
}
