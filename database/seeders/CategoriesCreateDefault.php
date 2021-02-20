<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesCreateDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => "Categoria producto"
            ], [
                'name' => "Sub categoria producto"
            ], [
                'name' => "Familia"
            ], [
                'name' => "Unidad medida"
            ], [
                'name' => "Moneda"
            ], [
                'name' => "Color"
            ], [
                'name' => "Grupo"
            ], [
                'name' => "Banco"
            ], [
                'name' => "Credito"
            ], [
                'name' => "Tipo gasto"
            ], [
                'name' => "Tipo proveedor"
            ], [
                'name' => "Tipo ingreso"
            ], [
                'name' => "Responsable"
            ], [
                'name' => "Estado del bien"
            ], [
                'name' => "Tipo salida"
            ]
        ]);
    }
}
