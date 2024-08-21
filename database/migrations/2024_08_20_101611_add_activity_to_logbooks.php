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
        Schema::table('logbooks', function (Blueprint $table) {
            $table->foreignId('activity_id')->nullable()->constrained();
            $table->boolean('completed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['activity_id']);
            // Then drop the column
            $table->dropColumn('activity_id');
            $table->dropColumn('completed');
        });
    }
};
