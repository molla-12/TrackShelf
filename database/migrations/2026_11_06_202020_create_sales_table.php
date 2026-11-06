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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained();

            $table->uuid('client_sale_id');

            $table->decimal('total_amount', 15, 2);
            $table->decimal('total_cost', 15, 2);
            $table->decimal('profit', 15, 2);

            $table->string('payment_method')->default('cash');

            $table->timestamp('sold_at');

            $table->timestamps();

            $table->unique(['shop_id', 'client_sale_id']);
            $table->index(['shop_id', 'sold_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
