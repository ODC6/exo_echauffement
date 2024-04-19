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
        Schema::create('dish', function (Blueprint $table) {
            $table->id();
            $table->string('dish_name');
            $table->string('slug');
            $table->string('dish_ingredient');
            $table->text('dish_recette');
            $table->time('preparation');
            $table->time('cuissons');
            $table->time('temps_total');
            $table->foreignId('id_category')->constrained('category')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish');
    }
};
