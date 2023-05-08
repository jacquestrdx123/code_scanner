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
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->integer('scan_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('security_registration')->nullable();
            $table->string('loading_registration')->nullable();
            $table->timestamp('invoice_time')->nullable();
            $table->timestamp('loading_time')->nullable();
            $table->timestamp('security_time')->nullable();
            $table->timestamp('pod_time')->nullable();
            $table->timestamps();
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
