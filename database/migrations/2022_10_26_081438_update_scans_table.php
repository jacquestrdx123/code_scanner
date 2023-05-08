<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('scans', function (Blueprint $table) {
                $table->string('current_state')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->timestamp('order_time')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->timestamp('picking_time')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->timestamp('confirmation_time')->nullable();
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scans');
    }
};
