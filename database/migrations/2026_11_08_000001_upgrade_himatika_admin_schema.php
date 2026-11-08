<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('password');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('avatar');
            }
        });

        // 2. Activity logs table
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('user_name')->default('Admin');
                $table->string('action'); // e.g., 'Tambah Berita', 'Update Profil'
                $table->string('model_type')->nullable();
                $table->unsignedBigInteger('model_id')->nullable();
                $table->text('description')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
            });
        }

        // 3. Profiles table: Home settings and meta
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'hero_badge')) {
                $table->string('hero_badge')->nullable()->default('HIMATIKA FMIPA UNUJA');
            }
            if (!Schema::hasColumn('profiles', 'hero_tagline')) {
                $table->string('hero_tagline')->nullable()->default('Synchronized Growth, Reaching New Heights');
            }
            if (!Schema::hasColumn('profiles', 'hero_title')) {
                $table->string('hero_title')->nullable()->default('Rumah yang inklusif, inovatif, dan tumbuh bersama.');
            }
            if (!Schema::hasColumn('profiles', 'hero_desc')) {
                $table->text('hero_desc')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'hero_image_alt')) {
                $table->string('hero_image_alt')->nullable()->default('HIMATIKA UNUJA 2026');
            }
            if (!Schema::hasColumn('profiles', 'hero_btn_primary_text')) {
                $table->string('hero_btn_primary_text')->nullable()->default('Hubungi Kami');
            }
            if (!Schema::hasColumn('profiles', 'hero_btn_primary_url')) {
                $table->string('hero_btn_primary_url')->nullable()->default('/kontak');
            }
            if (!Schema::hasColumn('profiles', 'hero_btn_secondary_text')) {
                $table->string('hero_btn_secondary_text')->nullable()->default('Pelajari Profil');
            }
            if (!Schema::hasColumn('profiles', 'hero_btn_secondary_url')) {
                $table->string('hero_btn_secondary_url')->nullable()->default('/profil');
            }
            if (!Schema::hasColumn('profiles', 'hero_stats_pengurus')) {
                $table->integer('hero_stats_pengurus')->default(68);
            }
            if (!Schema::hasColumn('profiles', 'hero_stats_bidang')) {
                $table->integer('hero_stats_bidang')->default(6);
            }
            if (!Schema::hasColumn('profiles', 'hero_stats_biro')) {
                $table->integer('hero_stats_biro')->default(4);
            }
            if (!Schema::hasColumn('profiles', 'stats_mode')) {
                $table->enum('stats_mode', ['auto', 'manual'])->default('auto');
            }
            if (!Schema::hasColumn('profiles', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'favicon')) {
                $table->string('favicon')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'footer_text')) {
                $table->text('footer_text')->nullable();
            }
        });

        // 4. News table: status, excerpt, image_alt, views
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'status')) {
                $table->enum('status', ['published', 'draft', 'archived'])->default('published')->after('author');
            }
            if (!Schema::hasColumn('news', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('title');
            }
            if (!Schema::hasColumn('news', 'image_alt')) {
                $table->string('image_alt')->nullable()->after('thumbnail');
            }
            if (!Schema::hasColumn('news', 'views')) {
                $table->unsignedInteger('views')->default(0)->after('status');
            }
        });

        // 5. Agendas table: start_time, end_time, registration_link, image, status
        Schema::table('agendas', function (Blueprint $table) {
            if (!Schema::hasColumn('agendas', 'start_time')) {
                $table->string('start_time')->nullable()->after('time');
            }
            if (!Schema::hasColumn('agendas', 'end_time')) {
                $table->string('end_time')->nullable()->after('start_time');
            }
            if (!Schema::hasColumn('agendas', 'registration_link')) {
                $table->string('registration_link')->nullable()->after('location');
            }
            if (!Schema::hasColumn('agendas', 'image')) {
                $table->string('image')->nullable()->after('registration_link');
            }
            if (!Schema::hasColumn('agendas', 'pub_status')) {
                $table->enum('pub_status', ['published', 'draft', 'archived'])->default('published')->after('status');
            }
        });

        // 6. Galleries table: status, order_num, alt_text
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'status')) {
                $table->enum('status', ['published', 'draft'])->default('published')->after('description');
            }
            if (!Schema::hasColumn('galleries', 'order_num')) {
                $table->integer('order_num')->default(0)->after('status');
            }
            if (!Schema::hasColumn('galleries', 'alt_text')) {
                $table->string('alt_text')->nullable()->after('image');
            }
        });

        // 7. Downloads table: category, file_size, file_type, status, author_name, website_url
        Schema::table('downloads', function (Blueprint $table) {
            if (!Schema::hasColumn('downloads', 'category')) {
                $table->string('category')->default('Website')->after('title');
            }
            if (!Schema::hasColumn('downloads', 'file_size')) {
                $table->string('file_size')->nullable()->after('file');
            }
            if (!Schema::hasColumn('downloads', 'file_type')) {
                $table->string('file_type')->nullable()->after('file_size');
            }
            if (!Schema::hasColumn('downloads', 'status')) {
                $table->enum('status', ['published', 'draft', 'archived'])->default('published')->after('file_type');
            }
            if (!Schema::hasColumn('downloads', 'author_name')) {
                $table->string('author_name')->nullable()->after('description');
            }
            if (!Schema::hasColumn('downloads', 'website_url')) {
                $table->string('website_url')->nullable()->after('author_name');
            }
        });

        // 8. Aspirations table: admin_notes, ip_address
        Schema::table('aspirations', function (Blueprint $table) {
            if (!Schema::hasColumn('aspirations', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('admin_reply');
            }
            if (!Schema::hasColumn('aspirations', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('admin_notes');
            }
        });

        // 9. Members table: is_active, order_num
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('bio');
            }
            if (!Schema::hasColumn('members', 'order_num')) {
                $table->integer('order_num')->default(0)->after('is_active');
            }
        });

        // 10. Organizational structures: period, order_num, is_active
        Schema::table('organizational_structures', function (Blueprint $table) {
            if (!Schema::hasColumn('organizational_structures', 'period')) {
                $table->string('period')->default('2026')->after('division');
            }
            if (!Schema::hasColumn('organizational_structures', 'order_num')) {
                $table->integer('order_num')->default(0)->after('period');
            }
            if (!Schema::hasColumn('organizational_structures', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('order_num');
            }
        });
    }

    public function down(): void
    {
        // Safe reversible migration
    }
};
