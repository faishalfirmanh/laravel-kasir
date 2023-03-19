<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('name_role', 100)->nullable()->change();
            $table->enum('kategori', ['0', '1'])->after('name_role')->nullable()->default('0');
            $table->enum('product', ['0', '1'])->after('kategori')->nullable()->default('0');
            $table->enum('kasir', ['0', '1'])->after('product')->nullable()->default('0');
            $table->enum('laporan', ['0', '1'])->after('kasir')->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            Schema::dropIfExists('kategori');
            Schema::dropIfExists('product');
            Schema::dropIfExists('kasir');
            Schema::dropIfExists('laporan');
        });
    }
}
