<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('updated_by')->nullable();
            $table->string('mandated');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('destiny');
            $table->text('comment');
            $table->string('applicant');
            $table->string('receive')->nullable();
            $table->string('authorizes')->nullable();
            $table->string('status')->default('Solicitado');
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
        Schema::dropIfExists('transfers');
    }
}
