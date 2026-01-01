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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        // Profil Laundry
        $table->string('nama_laundry')->default('Laundry Jaya');
        $table->string('whatsapp')->nullable();
        $table->text('alamat')->nullable();
        
        // Harga Utama (Biar gampang dipanggil di Dashboard)
        $table->integer('harga_kiloan')->default(7000);
        $table->integer('harga_setrika')->default(10000);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
