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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('author_id')->constrained('authers');
            $table->string('publisher');
            $table->dateTime('publishing_date');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('edition');
            $table->integer('pages');
            $table->integer('num_of_copies');
            $table->integer('available');
            $table->integer('shelf_num');
            $table->integer('num_of_borrowing');
            $table->integer('num_of_reading');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
