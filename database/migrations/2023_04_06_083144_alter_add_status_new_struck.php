<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddStatusNewStruck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('new_strucks', function (Blueprint $table) {
            $table->tinyInteger('status')->after('kembalian')->default(0);
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
           Schema::dropColumns('new_strucks','status');
        });
    }
}
