<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('areas') && !Schema::hasColumn('areas', 'can_take_attendance_from_any_dependency')) {
            Schema::table('areas', function (Blueprint $table) {
                $table->boolean('can_take_attendance_from_any_dependency')->default(false)->after('state');
            });
        }

        if (Schema::hasTable('users') && Schema::hasTable('areas') && !Schema::hasColumn('users', 'area_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('area_id')->nullable();
                $table->foreign('area_id')->references('id')->on('areas')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'area_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['area_id']);
                $table->dropColumn('area_id');
            });
        }

        if (Schema::hasTable('areas') && Schema::hasColumn('areas', 'can_take_attendance_from_any_dependency')) {
            Schema::table('areas', function (Blueprint $table) {
                $table->dropColumn('can_take_attendance_from_any_dependency');
            });
        }
    }
};
