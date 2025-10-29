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
        Schema::table('admin_documents', function (Blueprint $table) {
            $table->string('category')->after('title')->default('Memorandum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_documents', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
