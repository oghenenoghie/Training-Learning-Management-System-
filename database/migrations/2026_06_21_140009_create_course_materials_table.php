<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['video', 'pdf', 'document'])->default('pdf');
            $table->string('url');
            $table->integer('order')->default(0);
            $table->boolean('is_free_preview')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('course_materials'); }
};
