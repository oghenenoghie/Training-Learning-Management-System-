<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('enrolments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('course_schedules')->onDelete('set null');
            $table->enum('status', ['pending','enrolled','in_progress','completed','cancelled','waitlisted'])->default('pending');
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('progress')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('enrolments'); }
};
