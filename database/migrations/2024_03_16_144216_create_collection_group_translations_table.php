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
        Schema::create('collection_group_translations', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('collection_group_id')
                ->constrained('collection_groups')
                ->cascadeOnDelete();

            $table->string('locale')->index();
            $table->string("name");
            $table->unique(['collection_group_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_group_translations');
    }
};
