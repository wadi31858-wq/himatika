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
        Schema::table('organizational_structures', function (Blueprint $table) {
            if (!Schema::hasColumn('organizational_structures', 'group_photo')) {
                $table->string('group_photo')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('organizational_structures', 'group_photo_putri')) {
                $table->string('group_photo_putri')->nullable()->after('group_photo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizational_structures', function (Blueprint $table) {
            if (Schema::hasColumn('organizational_structures', 'group_photo_putri')) {
                $table->dropColumn('group_photo_putri');
            }
            if (Schema::hasColumn('organizational_structures', 'group_photo')) {
                $table->dropColumn('group_photo');
            }
        });
    }
};
