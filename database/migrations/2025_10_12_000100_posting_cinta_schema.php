<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Puskesmas
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->text('address')->nullable();
            $table->string('district', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('district');
            $table->index('is_active');
        });

        // Extend users (role, puskesmas_id, is_active, last_login_at)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->default('kader')->after('password'); // admin|puskesmas|kader
            }
            if (!Schema::hasColumn('users', 'puskesmas_id')) {
                $table->foreignId('puskesmas_id')->nullable()->after('role')->constrained('puskesmas')->nullOnDelete();
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('puskesmas_id');
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('is_active');
            }

            $table->index(['role', 'is_active']);
        });

        // Posyandu
        Schema::create('posyandu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puskesmas_id')->constrained('puskesmas')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('village', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->foreignId('kader_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['district', 'village']);
        });

        // Mothers (Ibu)
        Schema::create('mothers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posyandu_id')->constrained('posyandu')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('nik', 20)->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->foreignId('created_by')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('created_by');
        });

        // Children (Anak)
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained('mothers')->cascadeOnDelete();
            $table->foreignId('posyandu_id')->constrained('posyandu')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('nik', 20)->nullable()->unique();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['posyandu_id', 'mother_id']);
            $table->index(['gender', 'date_of_birth']);
            $table->index('created_by');
        });

        // Measurements (Pengukuran) - BB, TB, LK (optional)
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->cascadeOnDelete();
            $table->date('measured_at');
            $table->decimal('weight', 5, 2); // kg
            $table->decimal('height', 5, 2); // cm
            $table->decimal('head_circumference', 5, 2)->nullable(); // cm (optional)

            $table->integer('age_months');
            $table->decimal('weight_for_age_z', 5, 2)->nullable();
            $table->decimal('height_for_age_z', 5, 2)->nullable();
            $table->decimal('weight_for_height_z', 5, 2)->nullable();
            $table->string('nutrition_status', 50)->nullable(); // normal|stunting|severe
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('measured_at');
            $table->index('age_months');
            $table->index('nutrition_status');
            $table->index(['child_id', 'measured_at']);
        });

        // WHO Growth Standards (LMS)
        Schema::create('growth_standards', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['male', 'female']);
            // indicator: wfa (BB/U), hfa (TB/U), wfh (BB/TB)
            $table->enum('indicator', ['wfa', 'hfa', 'wfh']);

            // For wfa/hfa
            $table->integer('age_months')->nullable();

            // For wfh (weight-for-height), use length/height value in cm
            $table->decimal('length_height_cm', 5, 2)->nullable();

            // LMS parameters
            $table->decimal('l', 10, 6);
            $table->decimal('m', 10, 6);
            $table->decimal('s', 10, 6);

            $table->timestamps();

            $table->index(['gender', 'indicator', 'age_months']);
            $table->index(['gender', 'indicator', 'length_height_cm']);
        });

        // Recipes
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->enum('age_category', ['mpasi_6_12', 'balita_1_3', 'anak_3_5']);
            $table->string('image_path')->nullable();
            $table->text('ingredients');
            $table->text('instructions');
            $table->json('nutrition_info')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('protein')->nullable();
            $table->integer('carbohydrate')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['age_category', 'is_published']);
            $table->index('created_by');
        });

        // Sync Queue (Offline sync management)
        Schema::create('sync_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('entity_type', 50); // 'measurement','mother','child'
            $table->string('entity_id', 50)->nullable(); // local temp id (client)
            $table->string('action', 20); // 'create','update','delete'
            $table->json('payload'); // full payload
            $table->string('status', 20)->default('pending'); // pending|syncing|success|failed
            $table->text('error_message')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_queue');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('growth_standards');
        Schema::dropIfExists('measurements');
        Schema::dropIfExists('children');
        Schema::dropIfExists('mothers');
        Schema::dropIfExists('posyandu');

        // Rollback user columns
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'last_login_at')) {
                $table->dropColumn('last_login_at');
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('users', 'puskesmas_id')) {
                $table->dropConstrainedForeignId('puskesmas_id');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });

        Schema::dropIfExists('puskesmas');
    }
};
