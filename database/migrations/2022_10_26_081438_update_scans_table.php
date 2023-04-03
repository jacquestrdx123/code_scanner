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
        if (Schema::hasColumn('scans', 'order_nr')){
            Schema::table('scans', function (Blueprint $table) {
                $table->string('order_nr')->nullable();
            });
        }
        if (Schema::hasColumn('scans', 'start_pick')){
            Schema::table('scans', function (Blueprint $table) {
                $table->string('order_nr')->nullable();
            });
        }
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
