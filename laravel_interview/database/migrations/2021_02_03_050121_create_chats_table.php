<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('autor_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('write_by');
            $table->longText('message');
            $table->enum('status', ['SENDING', 'READING']);
            $table->enum('type', ['TEXT', 'IMAGE', 'AUDIO']);

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('autor_id')->references('id')->on('users');
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('write_by')->references('id')->on('users');
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
        Schema::dropIfExists('chats');
    }
}
