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
        Schema::create('coach_translations', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('coach_id')
                ->constrained('coaches')
                ->cascadeOnDelete();
            
            $table->string("name");
            $table->string('locale')->index();
            $table->text('about_me');
            $table->text('resume')->nullable();
            $table->text('job_experience')->nullable();
            $table->text('education_record')->nullable();

            $table->unique(["locale", "coach_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_translations');
    }
};
