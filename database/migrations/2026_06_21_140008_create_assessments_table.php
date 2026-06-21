<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['mcq', 'short_answer', 'file_upload'])->default('mcq');
            $table->integer('pass_score')->default(70);
            $table->integer('max_attempts')->default(3);
            $table->timestamps();
        });
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->string('type')->default('mcq');
            $table->json('options')->nullable();
            $table->text('correct_answer')->nullable();
            $table->integer('marks')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
        Schema::create('assessment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('answers');
            $table->integer('score')->default(0);
            $table->boolean('passed')->default(false);
            $table->integer('attempt_number')->default(1);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('assessment_submissions');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessments');
    }
};
