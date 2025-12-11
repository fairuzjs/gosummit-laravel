<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('mountains', function (Blueprint $table) {
        // Menambahkan kolom height setelah ticket_price
        $table->integer('height')->after('ticket_price')->default(0)->comment('Ketinggian dalam MDPL');
    });
}

public function down()
{
    Schema::table('mountains', function (Blueprint $table) {
        $table->dropColumn('height');
    });
}
};
