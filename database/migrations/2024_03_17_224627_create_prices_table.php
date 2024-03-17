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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('customer_group_id')->nullable()->constrained($this->prefix.'customer_groups');
//            $table->foreignId('currency_id')->nullable()->constrained($this->prefix.'currencies');
            $table->morphs('priceable');
            $table->integer('price')->unsigned()->index();
//            $table->integer('compare_price')->unsigned()->nullable();
//            $table->integer('tier')->default(1)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
