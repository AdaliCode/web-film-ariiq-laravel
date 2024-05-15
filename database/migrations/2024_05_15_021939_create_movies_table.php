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
        Schema::create('movies', function (Blueprint $table) {
            $table->string('id', 100)->nullable(false)->primary();
            $table->string('title', 100)->nullable(false);
            $table->text('description')->nullable(true);
            $table->integer('price')->nullable(false);
            $table->string('category_id', 100)->nullable(false);
            $table->timestamp('create_at')->useCurrent();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
