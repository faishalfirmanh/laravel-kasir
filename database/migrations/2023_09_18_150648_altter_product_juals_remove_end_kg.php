<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AltterProductJualsRemoveEndKg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_juals', function (Blueprint $table) {
            $table->dropColumn('end_kg');
            $table->renameColumn('start_kg', 'satuan_berat_item');
            
            // if (Schema::hasColumn('product_juals', 'start_kg'))
            // {
                
            // }
           
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
            Schema::dropIfExists(['end_kg','start_kg']);
        });
    }
}
