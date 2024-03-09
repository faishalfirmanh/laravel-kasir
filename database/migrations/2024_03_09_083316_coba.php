<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Coba extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Coba', function (Blueprint $table) {
            $table->id('no_form');
            $table->date('tanggal');
            $table->string('tempat',100);
            $table->string('nama_peminjam',100);
            $table->string('departement',100);
            $table->string('jabatan',100);
            $table->string('tujuan',100);
            $table->string('keperluan',100);
            $table->string('catatan_kusus',100);
            $table->tinyInteger('driver')->default(0);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_pengembalian');
            $table->string('manager');
            $table->string('hrd');
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
        //
    }
}
