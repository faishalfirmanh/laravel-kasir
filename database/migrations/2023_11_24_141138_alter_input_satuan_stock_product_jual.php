<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInputSatuanStockProductJual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_juals', function (Blueprint $table) {
            $table->decimal('satuan_berat_item',10,4)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_juals', function (Blueprint $table) {
            Schema::dropIfExists('satuan_berat_item');
        });
    }
}
