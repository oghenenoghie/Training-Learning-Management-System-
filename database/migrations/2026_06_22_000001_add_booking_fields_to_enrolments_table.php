<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('enrolments', function (Blueprint $table) {
            $table->enum('booker_type', ['individual', 'company'])->default('individual')->after('progress');
            $table->string('company_name')->nullable()->after('booker_type');
            $table->string('contact_person')->nullable()->after('company_name');
            $table->string('contact_email')->nullable()->after('contact_person');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('company_address')->nullable()->after('contact_phone');
            $table->string('po_number')->nullable()->after('company_address');
            $table->integer('number_of_delegates')->default(1)->after('po_number');
            $table->json('delegate_names')->nullable()->after('number_of_delegates');
            $table->enum('payment_method', ['paystack', 'flutterwave', 'invoice'])->nullable()->after('delegate_names');
            $table->decimal('subtotal', 10, 2)->nullable()->after('payment_method');
            $table->decimal('vat_amount', 10, 2)->nullable()->after('subtotal');
            $table->decimal('total_amount', 10, 2)->nullable()->after('vat_amount');
            $table->string('booking_reference')->nullable()->unique()->after('total_amount');
        });
    }

    public function down(): void {
        Schema::table('enrolments', function (Blueprint $table) {
            $table->dropColumn([
                'booker_type', 'company_name', 'contact_person', 'contact_email',
                'contact_phone', 'company_address', 'po_number', 'number_of_delegates',
                'delegate_names', 'payment_method', 'subtotal', 'vat_amount',
                'total_amount', 'booking_reference',
            ]);
        });
    }
};
