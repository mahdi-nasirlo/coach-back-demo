<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCollectionsTable extends Migration
{

    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_group_id')->constrained('collection_groups');
            $table->nestedSet();
            $table->string('type')->default('static')->index();
            $table->json('attribute_data');
            $table->string('sort')->default('custom')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
}
