<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeranjangKasirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjang_kasirs', function (Blueprint $table) {
            $table->id('id_keranjang_kasir');
            $table->unsignedBigInteger("product_jual_id");//untuk harga product jual
            $table->integer("jumlah_item_dibeli");
            $table->integer("total_harga_item");
            $table->tinyInteger('status')->nullable()->default(0);
            $table->unsignedBigInteger("struck_id")->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('product_jual_id')->references('id_product_jual')->on('product_juals');
            $table->foreign('struck_id')->references('id_struck')->on('new_strucks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keranjang_kasirs');
    }
}
