<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('enrolment_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('NGN');
            $table->string('reference')->unique();
            $table->enum('gateway', ['paystack', 'flutterwave'])->default('paystack');
            $table->enum('status', ['pending','paid','failed','refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};
