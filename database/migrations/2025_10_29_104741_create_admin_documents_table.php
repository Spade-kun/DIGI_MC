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
        Schema::create('admin_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('case_no');
            $table->date('date_issued');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('google_drive_id')->nullable();
            $table->string('uploaded_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_documents');
    }
};
