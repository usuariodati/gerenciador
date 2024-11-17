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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plataform_id')->constrained('plataforms')->cascadeOnDelete();
            $table->string('name');
            $table->integer('total_modules')->default(0);
            $table->integer('total_classes')->default(0);
            $table->integer('done_modules')->default(0);
            $table->integer('done_classes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
