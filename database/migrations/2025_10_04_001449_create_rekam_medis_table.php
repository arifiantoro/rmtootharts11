<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->onDelete('set null');
            $table->string('alergi')->nullable();
            $table->boolean('hamil')->default(false);
            $table->boolean('mag')->default(false);
            $table->text('riwayat_penyakit')->nullable();
            $table->text('catatan_khusus')->nullable();
            $table->text('keterangan_karies')->nullable();
            $table->text('gigi_hilang')->nullable();
            $table->text('sisa_akar')->nullable();
            $table->text('belum_erupsi')->nullable();
            $table->text('karang_gigi')->nullable();
            $table->string('jenis_pasien', 50)->default('Umum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
