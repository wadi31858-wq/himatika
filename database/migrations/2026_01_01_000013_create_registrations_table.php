<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nim');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('study_program')->nullable();
            $table->string('semester')->nullable();
            $table->longText('reason')->nullable();
            $table->longText('experience')->nullable();
            $table->longText('skills')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
