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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Order::class);
            $table->foreignIdFor(\App\Models\Product::class);

            $table->decimal("price", 10, 2);
            $table->integer("qty");
            $table->decimal("total_price", 10, 2);
            $table->integer("tax");
            $table->decimal("tax_price", 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
