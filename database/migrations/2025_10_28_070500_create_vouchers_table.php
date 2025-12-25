<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode voucher, misalnya: "DISKON10"
            $table->string('name'); // Nama voucher, misalnya: "Diskon 10%"

            $table->enum('type', ['percentage', 'fixed']); // Jenis diskon
            $table->decimal('value', 10, 2); // Nilai diskon, misalnya: 10 (untuk 10%) atau 5000 (untuk Rp 5.000)

            $table->dateTime('valid_from')->nullable(); // Tanggal mulai berlaku
            $table->dateTime('valid_until')->nullable(); // Tanggal kadaluarsa

            $table->integer('usage_limit')->default(0); // Batas penggunaan total (0 = tidak terbatas)
            $table->integer('used_count')->default(0); // Jumlah sudah digunakan

            $table->integer('user_usage_limit')->default(1); // Batas penggunaan per user (misalnya: 1x per user)

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}