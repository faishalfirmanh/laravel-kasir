<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductJualAddIdBeli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_juals', function (Blueprint $table) {
            $table->unsignedBigInteger("product_beli_id")->nullable()->after('product_id');
            $table->foreign('product_beli_id')->references('id_product_beli')->on('product_belis');
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
            Schema::dropIfExists('id_product_beli');
        });
    }
}
