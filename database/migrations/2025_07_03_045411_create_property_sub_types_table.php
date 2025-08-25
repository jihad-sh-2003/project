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
        Schema::create('property_sub_types', function (Blueprint $table) {
            $table->id();
            $table->enum('subtype', [
        'house', 'apartment', 'land', 'villa', 'factory',
        'office', 'store', 'hotel', 'resturant', 'warehouse',
        'farm', 'greenhouse'
            ]);
                $table->foreignId('type_id')->constrained('property_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_sub_types');
    }
};
