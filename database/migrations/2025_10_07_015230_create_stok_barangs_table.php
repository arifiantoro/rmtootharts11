<?php

// database/migrations/xxxx_xx_xx_create_stok_barangs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stok_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->enum('kategori', ['Obat kumur', 'Anti nyeri', 'Antibiotik', 'Lainnya'])->default('Lainnya');
            $table->string('satuan')->nullable();
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 12, 2)->nullable();
            $table->decimal('harga_jual', 12, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('stok_barangs');
    }
};


