<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->enum('unit', ['Kg', 'Pcs', 'Meter']);
            $table->integer('price');
            $table->string('estimation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('invoice_code')->unique();
            $table->integer('total_price');
            $table->enum('status_order', ['Menunggu', 'Dicuci', 'Disetrika', 'Siap Diambil', 'Selesai'])->default('Menunggu');
            $table->enum('payment_status', ['Belum Bayar', 'Lunas'])->default('Belum Bayar');
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained();
            $table->double('qty');
            $table->integer('price_at_time');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop urutannya dibalik agar tidak bentrok relasi
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('services');
        Schema::dropIfExists('customers');
    }
};