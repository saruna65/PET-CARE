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
        Schema::table('vets', function (Blueprint $table) {
            // Add is_verified column after is_available column
            // Default to false so existing vets need to be verified
            $table->boolean('is_verified')->default(false)->after('is_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vets', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
};
