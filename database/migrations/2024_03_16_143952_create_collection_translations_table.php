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
        Schema::create('collection_translations', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('collection_id')
                ->constrained('collections')
                ->cascadeOnDelete();

            $table->string('locale')->index();
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("slug");
            $table->string("url")->nullable();

            $table->unique(['collection_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_translations');
    }
};
