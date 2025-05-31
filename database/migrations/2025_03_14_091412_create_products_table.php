<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->String('product_id');
            $table->String('product_name');
            $table->String('product_brand');
            $table->String('gender');
            $table->BigInteger('price');
            $table->longText('description');
            $table->String('primary_color');
            $table->String('jenis_pakaian');
            $table->Float('discount');
            $table->Integer('quantity');
            $table->Integer('quantity_out')-> default(0);
            $table->string('foto');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
