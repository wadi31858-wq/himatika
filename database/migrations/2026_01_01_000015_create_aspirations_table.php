<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nim')->nullable();
            $table->string('email')->nullable();
            $table->string('category')->nullable();
            $table->string('title');
            $table->text('message');
            $table->enum('status', ['Baru', 'Dibaca', 'Diproses', 'Selesai'])->default('Baru');
            $table->text('admin_reply')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirations');
    }
};
