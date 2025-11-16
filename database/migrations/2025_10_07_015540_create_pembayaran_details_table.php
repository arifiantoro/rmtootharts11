<?php

// database/migrations/xxxx_xx_xx_create_pembayaran_details_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('stok_barangs')->onDelete('set null');
            $table->foreignId('perawatan_id')->nullable()->constrained('perawatans')->onDelete('set null');
            $table->string('deskripsi'); // nama barang / tindakan
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembayaran_details');
    }
};


