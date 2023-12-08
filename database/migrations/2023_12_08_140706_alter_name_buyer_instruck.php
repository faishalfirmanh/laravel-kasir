<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNameBuyerInstruck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_strucks', function (Blueprint $table) {
            $table->string('nama_pembeli',20)->after('keuntungan_bersih')->nullable();
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_strucks', function (Blueprint $table) {
            Schema::dropIfExists('nama_pembeli');
        });
    }
}
