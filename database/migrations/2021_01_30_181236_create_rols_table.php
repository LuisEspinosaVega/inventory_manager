<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rols', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->tinyInteger('main_admin')->default(0);
            $table->tinyInteger('main_inventory')->default(0);
            $table->tinyInteger('edit_inventory')->default(0);
            $table->tinyInteger('main_rh')->default(0);
            $table->tinyInteger('edit_rh')->default(0);
            $table->tinyInteger('main_social')->default(0);
            $table->tinyInteger('edit_social')->default(0);
            $table->tinyInteger('main_finance')->default(0);
            $table->tinyInteger('edit_finance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rols');
    }
}
