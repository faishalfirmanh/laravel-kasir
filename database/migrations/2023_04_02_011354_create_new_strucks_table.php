<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewStrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_strucks', function (Blueprint $table) {
            $table->id('id_struck');
            $table->integer('total_harga_dibayar')->default(0)->nullable();//awalnya 0
            $table->integer('pembeli_bayar')->default(0)->nullable();
            $table->integer('kembalian')->default(0)->nullable();
            $table->integer('keuntungan_bersih')->default(0)->nullable();
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
        Schema::dropIfExists('new_strucks');
    }
}
