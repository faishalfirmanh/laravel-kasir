<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddHargaTiapItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keranjang_kasirs', function (Blueprint $table) {
            $table->integer('harga_tiap_item')->after('jumlah_item_dibeli')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keranjang_kasirs', function (Blueprint $table) {
            Schema::dropIfExists('harga_tiap_item');
        });
    }
}
