<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('notifications_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('subject');
            $table->text('body');
            $table->timestamp('sent_at')->nullable();
            $table->enum('channel', ['email', 'sms'])->default('email');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('notifications_log'); }
};
