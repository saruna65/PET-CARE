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
        Schema::table('vet_diseases', function (Blueprint $table) {
            $table->boolean('has_zoonotic_risk')->default(false)->after('is_critical');
            $table->text('zoonotic_precautions')->nullable()->after('has_zoonotic_risk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vet_diseases', function (Blueprint $table) {
            $table->dropColumn('has_zoonotic_risk');
            $table->dropColumn('zoonotic_precautions');
        });
    }
};
