<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_role')->after('id');
            $table->unsignedBigInteger('id_branch')->nullable()->after('id_role');

            $table->foreign('id_role')
                ->references('id_role')
                ->on('roles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_branch')
                ->references('id_branch')
                ->on('branches')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropForeign(['id_branch']);
            $table->dropColumn(['id_role', 'id_branch']);
        });
    }
};

