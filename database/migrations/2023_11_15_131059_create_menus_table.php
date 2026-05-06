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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->enum('visibility', ['public', 'private']);
            $table->enum('stock', ['tersedia', 'habis']);
            $table->string('title');
            $table->string('description');
            $table->enum('category', ['makanan', 'minuman', 'paket']);
            $table->bigInteger('favorite')->default(0);
            $table->bigInteger('sold')->default(0);
            $table->integer('price');
            $table->integer('discount');
            $table->float('rating')->default(0);
            $table->string('picture');
            $table->string('video');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
