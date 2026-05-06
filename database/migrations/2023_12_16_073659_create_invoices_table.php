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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->uuid('user_id');
            $table->string('token');
            $table->json('menus');
            $table->integer('table_number');
            $table->integer('total_price');
            $table->enum('payment_method', ['cash']);
            $table->enum('status', ['menunggu pembayaran', 'sedang disiapkan', 'selesai']);
            $table->boolean('already_paid')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('uuid')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
