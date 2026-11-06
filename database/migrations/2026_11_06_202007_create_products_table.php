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

            $table->foreignId('shop_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable();

            $table->string('sku');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();

            $table->decimal('buying_price', 15, 2);
            $table->decimal('selling_price', 15, 2);

            $table->decimal('quantity', 15, 3)->default(0);
            $table->decimal('reorder_level', 15, 3)->default(5);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign(['shop_id', 'category_id'])
                ->references(['shop_id', 'id'])
                ->on('categories');

            $table->unique(['shop_id', 'sku']);
            $table->unique(['shop_id', 'id']);
            $table->index(['shop_id', 'name']);
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
