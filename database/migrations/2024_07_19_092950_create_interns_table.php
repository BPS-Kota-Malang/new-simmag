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
        Schema::create('interns', function (Blueprint $table) {
            $table->id('id');
            $table->string('nim');
            $table->string('name');
            $table->foreignId('university_id')->constrained()->nullable();
            $table->foreignId('faculty_id')->constrained()->nullable();
            $table->foreignid('department_id')->constrained()->nullable();
            $table->string('phone');
            // $table->integer('jumlah_anggota');
            $table->string('file_proposal');
            $table->string('file_suratpengantar');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('user_id')->constrained()->nullable();
            $table->foreignId('division_id')->constrained()->nullable();
            $table->enum('work_status', ['accepted', 'on progress', 'rejected'])->default('on progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
