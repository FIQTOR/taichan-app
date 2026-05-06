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
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('uuid')->on('users');
            $table->string('fullname');
            $table->string('email');
            $table->string('phonenumber');
            $table->enum('type', ['saran/kritik', 'berbagi pengalaman', 'pertanyaan']);
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
