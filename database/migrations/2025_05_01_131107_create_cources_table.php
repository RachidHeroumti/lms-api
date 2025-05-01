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
        Schema::create('cources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('slug')->unique();
            $table->json('pdfs')->nullable(); 
            $table->json('videos')->nullable();
            $table->string('category')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('duration')->nullable(); 
            $table->string('level')->default('beginner'); 
            $table->boolean('is_free')->default(false);
            $table->decimal('price', 8, 2)->nullable();
            $table->string('language')->default('en');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cources');
    }
};
