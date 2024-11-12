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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->integer("order_no");
            $table->tinyInteger("payment_method");
            $table->tinyInteger("order_status");
            $table->decimal("total_price", 10, 2);
            $table->integer("total_qty");
            $table->decimal("tax_total_price", 10, 2);

            $table->string("name");
            $table->string('company');
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
