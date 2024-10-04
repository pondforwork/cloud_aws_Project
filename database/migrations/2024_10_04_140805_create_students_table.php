<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('name');
            $table->string('surname');
            $table->integer('age');
            $table->integer('year');
            $table->enum('sex', ['m', 'f']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
