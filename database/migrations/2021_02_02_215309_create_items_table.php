<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalog_id')->index();
            $table->string('serial_number');
            $table->string('lot')->nullable();
            $table->string('caducity')->nullable();
            $table->tinyInteger('color_primary');
            $table->tinyInteger('color_secondary')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('group')->nullable();
            $table->tinyInteger('family')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->bigInteger('stock')->default(0);
            $table->bigInteger('min_stock')->default(0);
            $table->bigInteger('max_stock')->default(0);
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
        Schema::dropIfExists('items');
    }
}
