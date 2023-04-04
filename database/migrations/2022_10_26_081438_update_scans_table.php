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
                $table->string('order_nr')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->string('invoice_number')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->string('loading_registration')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->string('security_registration')->nullable();
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
            Schema::table('scans', function (Blueprint $table) {
                $table->timestamp('invoice_time')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->timestamp('loading_time')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->timestamp('security_time')->nullable();
            });
            Schema::table('scans', function (Blueprint $table) {
                $table->timestamp('pod_time')->nullable();
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
