<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltterProductJualsChangeTipedata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_juals', function (Blueprint $table) {
            if (Schema::hasColumn('product_juals', 'satuan_berat_item'))
            {
                $table->decimal('satuan_berat_item')->change();
            }
           
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
            //
        });
    }
}
