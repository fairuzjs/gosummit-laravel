<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrailRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('trail_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mountain_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nama jalur, misal: "Jalur Via Tegal"
            $table->text('description')->nullable(); // Deskripsi singkat
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trail_routes');
    }
}