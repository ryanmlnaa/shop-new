<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('code_transaksi')->change();
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->integer('code_transaksi')->change(); // jika sebelumnya integer
        });
    }

};
