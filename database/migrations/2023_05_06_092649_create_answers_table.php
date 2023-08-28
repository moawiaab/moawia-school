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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ask_id')->foreign('ask_id')->references('id')->on('test_models')->nullable();
            $table->bigInteger('answer_id')->foreign('answer_id')->references('id')->on('test_items')->nullable();
            $table->foreignUuid('tutorial_id')->constrained('tutorials')->nullable();
            $table->bigInteger('user_id')->foreign('user_id')->references('id')->on('users')->nullable();
            $table->bigInteger('material_id')->foreign('material_id')->references('id')->on('teacher_material_levels')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
