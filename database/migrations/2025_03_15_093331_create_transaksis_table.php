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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code_transaksi')->unsigned()->unique();
            $table->string('sku_transaksi');
            $table->string('total_qty');
            $table->string('total_harga');
            $table->string('nama_customer');
            $table->string('alamat');
            $table->string('no_tlp');
            $table->string('ekspedisi');
            $table->enum('status', ['Unpaid','Paid']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
