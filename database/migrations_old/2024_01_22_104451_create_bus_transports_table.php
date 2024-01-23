<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bus_transports', function (Blueprint $table) {
            $table->bigIncrements('bus_id');
            $table->integer('event_type', 100);
            $table->string('bus_type', 100);
            $table->string('bus_num', 100);
            $table->integer('status', false, false)->length(1)->comment('0:Deleted, 1:Active')->default(1);
            $table->time('time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_transports');
    }
};
