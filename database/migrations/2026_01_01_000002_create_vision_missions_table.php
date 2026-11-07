<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vision_missions', function (Blueprint $table) {
            $table->id();
            $table->longText('vision');
            $table->longText('mission');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vision_missions');
    }
};
