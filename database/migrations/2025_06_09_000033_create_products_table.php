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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merk_id')->constrained('merks');
            $table->string('kategori');
            $table->string('model');
            $table->decimal('harga',20,2);
            $table->decimal('bobot');
            $table->decimal('cpu_score');
            $table->decimal('gpu_score');
            $table->json('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
