<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tabel untuk menghitung keuntungan
        Schema::create('product_belis', function (Blueprint $table) {
            $table->id('id_product_beli');
            $table->unsignedBigInteger("product_id");
            $table->integer('harga_beli_custom');//harga beli kulat tiap product
            $table->string('nama_product_variant')->nullable();

            $table->foreign('product_id')->references('id_product')->on('products');
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
        Schema::dropIfExists('product_belis');
    }
}
