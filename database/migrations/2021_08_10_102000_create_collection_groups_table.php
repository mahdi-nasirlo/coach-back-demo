<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionGroupsTable extends Migration
{
    public function up(): void
    {
        Schema::create('collection_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("handle");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_groups');
    }
}
