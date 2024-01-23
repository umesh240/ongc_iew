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
        Schema::create('chattings', function (Blueprint $table) {
            $table->bigIncrements('chat_id');
            $table->integer('user_id')->length(10);  // can be user or admin id
            $table->longText('message');
            $table->string('user_type', 10)->comment('user/admin');  //   user/admin
            $table->integer('chat_user_id')->length(10)->default(0);
            $table->integer('chat_resp_id')->length(10)->default(0);
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chattings');
    }
};

