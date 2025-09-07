<?php
// Run this command in terminal:
// php artisan make:migration create_vets_table

// filepath: c:\xampp\xampp\htdocs\PET-CARE\database\migrations\xxxx_xx_xx_create_vets_table.php


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
        Schema::create('vets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('clinic_name')->nullable();
            $table->string('specialization');
            $table->unsignedInteger('experience_years');
            $table->string('qualification');
            $table->string('license_number')->unique();
            $table->text('biography')->nullable();
            $table->json('services_offered')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone_number');
            $table->string('website')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0.00);
            $table->string('image_path')->nullable();
            $table->boolean('is_available')->default(true);
            $table->json('availability_hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vets');
    }
};