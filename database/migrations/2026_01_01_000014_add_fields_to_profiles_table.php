<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('motto')->nullable()->after('content');
            $table->longText('philosophy')->nullable()->after('motto');
            $table->longText('mars')->nullable()->after('philosophy');
            $table->longText('history')->nullable()->after('mars');
            $table->string('logo')->nullable()->after('image');
            $table->string('campus_name')->nullable()->after('logo');
            $table->string('address')->nullable()->after('campus_name');
            $table->string('email')->nullable()->after('address');
            $table->string('phone')->nullable()->after('email');
            $table->string('instagram')->nullable()->after('phone');
            $table->string('youtube')->nullable()->after('instagram');
            $table->string('tiktok')->nullable()->after('youtube');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'motto', 'philosophy', 'mars', 'history',
                'logo', 'campus_name', 'address', 'email',
                'phone', 'instagram', 'youtube', 'tiktok',
            ]);
        });
    }
};
