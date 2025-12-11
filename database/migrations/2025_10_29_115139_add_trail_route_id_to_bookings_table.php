<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrailRouteIdToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('trail_route_id')->nullable()->constrained('trail_routes')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['trail_route_id']);
            $table->dropColumn('trail_route_id');
        });
    }
}