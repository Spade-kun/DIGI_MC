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
        Schema::create('tracking_documents', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_no')->unique();
            $table->string('name');
            $table->string('source_office');
            $table->string('document_type');
            $table->string('privacy');
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('status')->default('Received'); // Received, Drafting, For Review, Revision, Approved
            $table->string('origin_unit')->nullable();
            $table->text('remarks')->nullable();
            $table->string('uploaded_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_documents');
    }
};
