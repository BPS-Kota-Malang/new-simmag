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
        Schema::table('applies', function (Blueprint $table) {
            $table->string('causes')->nullable()->after('end_date_answer');            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applies', function (Blueprint $table) {
            $table->dropColumn('causes');
            //
        });
    }
};
