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
            $table->string('vet_diagnosis')->nullable();
            $table->text('vet_treatment')->nullable();
            $table->text('vet_notes')->nullable();
            $table->boolean('is_critical')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vet_diseases', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn([
                'vet_diagnosis',
                'vet_treatment',
                'vet_notes',
                'is_critical',
                'reviewed_at',
                'reviewed_by'
            ]);
        });
    }
};