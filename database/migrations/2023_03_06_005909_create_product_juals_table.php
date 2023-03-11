<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductJualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_juals', function (Blueprint $table) {
            $table->id('id_product_jual');
            $table->unsignedBigInteger("product_id");
            $table->integer('start_kg');
            $table->integer('end_kg');
            $table->integer('price_sell');
            $table->timestamps();

            $table->foreign('product_id')->references('id_product')->on('products');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_juals');
    }
}
