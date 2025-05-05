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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('question');
            $table->text('description')->nullable();
            $table->string('option_1');
            $table->string('option_2');
            $table->string('option_3');
            $table->string('option_4');
            $table->string('option_5')->nullable();
            $table->tinyInteger('correct_option');
            $table->foreignId('cource_id')->constrained('cources')->onDelete('cascade');

            //Using $table->tinyInteger('correct_option') is:

            // ✅ Efficient — uses very little storage (1 byte)

            // ✅ Practical — great for storing small numbers like 1–5

            // ✅ Scalable — lets you reference the correct answer by its option number

            // ✅ Easy to validate and process in code
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
