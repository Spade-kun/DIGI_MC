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
        Schema::table('user_folder_privileges', function (Blueprint $table) {
            $table->boolean('can_add')->default(false)->after('can_access');
            $table->boolean('can_edit')->default(false)->after('can_add');
            $table->boolean('can_view')->default(false)->after('can_edit');
            $table->boolean('can_delete')->default(false)->after('can_view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_folder_privileges', function (Blueprint $table) {
            $table->dropColumn(['can_add', 'can_edit', 'can_view', 'can_delete']);
        });
    }
};
