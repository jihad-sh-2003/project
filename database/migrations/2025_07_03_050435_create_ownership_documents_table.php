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
        Schema::create('ownership_documents', function (Blueprint $table) {
         $table->id();
            $table->string('document_type')->nullable();
            $table->string('document_url')->nullable();
            $table->timestamp('upload_at')->nullable();
            $table->timestamps();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ownership_documents');
    }
};
