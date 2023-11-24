<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTotalDecimalByStockKeranjangKasir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keranjang_kasirs', function (Blueprint $table) {
            $table->decimal('total_decimal_buy_for_stock',12,5)->nullable()->change();
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
            Schema::dropIfExists('total_decimal_buy_for_stock');
        });
    }
}
