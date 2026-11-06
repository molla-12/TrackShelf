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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shop_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained();

            $table->foreignId('user_id')
                ->constrained();

            $table->foreignId('sale_id')
                ->nullable()
                ->constrained();

            $table->enum('movement_type', [
                'opening',
                'purchase',
                'sale',
                'adjustment',
                'return',
                'damage'
            ]);

            // Positive for stock-in, negative for stock-out.
            $table->decimal('quantity_change', 15, 3);

            $table->decimal('quantity_before', 15, 3);
            $table->decimal('quantity_after', 15, 3);

            $table->string('reference')->nullable();
            $table->text('notes')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['shop_id', 'product_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
