<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Prompts\Table;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('type_id')->constrained('property_types');
            $table->foreignId('subtype_id')->constrained('property_sub_types');
            $table->string('title', 255);
           // $table->string('subtype', 100);
            $table->enum('status', ['sale', 'rent', 'reserved']);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->float('area');
            $table->integer('floor')->nullable();
            $table->integer('rooms_count')->nullable();
            //location
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            
            $table->boolean('has_pool')->default(false);
            $table->boolean('has_garden')->default(false);
            $table->boolean('has_elevator')->default(false);
            $table->boolean('solar_energy')->default(false);
            $table->text('features')->nullable();
            $table->text('nearby_services')->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
