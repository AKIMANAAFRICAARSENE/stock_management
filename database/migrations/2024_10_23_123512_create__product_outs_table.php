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
        Schema::create('product_outs', function (Blueprint $table) {
            $table->id();
            $table->string('ProductCode', 255);  // Ensure same type and length as in products
            $table->foreign('ProductCode')
                  ->references('ProductCode')
                  ->on('products');
                  
            $table->dateTime('DateTime');
            $table->integer('Quantity');
            $table->decimal('UnitPrice', 8, 2);
            $table->decimal('TotalPrice', 8, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_outs');
    }
};