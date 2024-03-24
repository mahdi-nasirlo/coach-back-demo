<?php

use App\Enums\ProductTypeEnums;
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
//            $table->foreignId('brand_id')
//                ->nullable()
//                ->constrained('brands');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->string('status')->index();
            $table->enum("product_type", ProductTypeEnums::values());
            $table->softDeletes();
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
