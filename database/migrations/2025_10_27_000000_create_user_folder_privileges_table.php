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
        Schema::create('user_folder_privileges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('folder_id'); // Google Drive folder ID
            $table->string('folder_name')->nullable(); // Cached folder name
            $table->boolean('can_access')->default(true);
            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['user_id', 'folder_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_folder_privileges');
    }
};
