<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('organizational_structures') && !Schema::hasColumn('organizational_structures', 'kelompok')) {
            Schema::table('organizational_structures', function (Blueprint $table) {
                $table->string('kelompok', 20)->default('semua')->after('division');
            });
        }

        if (Schema::hasTable('members') && !Schema::hasColumn('members', 'kelompok')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('kelompok', 20)->default('putra')->after('division');
            });
        }

        // Populate existing organizational_structures
        if (Schema::hasTable('organizational_structures')) {
            DB::table('organizational_structures')
                ->where('position', 'like', '%putra%')
                ->orWhere('division', 'like', '%putra%')
                ->orWhere('name', 'like', '%Ahmad Rizki%')
                ->orWhere('name', 'like', '%Budi Santoso%')
                ->orWhere('name', 'like', '%Farhan%')
                ->update(['kelompok' => 'putra']);

            DB::table('organizational_structures')
                ->where('position', 'like', '%putri%')
                ->orWhere('division', 'like', '%putri%')
                ->orWhere('name', 'like', '%Siti Nurhaliza%')
                ->orWhere('name', 'like', '%Dewi Lestari%')
                ->orWhere('name', 'like', '%Nurul Aini%')
                ->update(['kelompok' => 'putri']);

            // Kaprodi / Pembina applies to all
            DB::table('organizational_structures')
                ->where('position', 'like', '%kaprodi%')
                ->orWhere('position', 'like', '%pembina%')
                ->update(['kelompok' => 'semua']);
        }

        // Populate existing members
        if (Schema::hasTable('members')) {
            // Putri list
            $putriNames = ['Siti Nurhaliza', 'Dewi Lestari', 'Rina Sari', 'Maya Putri', 'Lestari Wulan', 'Salma Amalia', 'Nurul Aini'];
            foreach ($putriNames as $pName) {
                DB::table('members')
                    ->where('name', 'like', "%{$pName}%")
                    ->update(['kelompok' => 'putri']);
            }

            // Putra list
            $putraNames = ['ahmad adi wijaya', 'Ahmad Rizki', 'Budi Santoso', 'Fajar Nugroho', 'Andi Pratama', 'Eko Prasetyo', 'Dimas Maulana', 'Bayu Wicaksono', 'Ilham Maulana', 'M. Farhan'];
            foreach ($putraNames as $pName) {
                DB::table('members')
                    ->where('name', 'like', "%{$pName}%")
                    ->update(['kelompok' => 'putra']);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('organizational_structures') && Schema::hasColumn('organizational_structures', 'kelompok')) {
            Schema::table('organizational_structures', function (Blueprint $table) {
                $table->dropColumn('kelompok');
            });
        }

        if (Schema::hasTable('members') && Schema::hasColumn('members', 'kelompok')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('kelompok');
            });
        }
    }
};
