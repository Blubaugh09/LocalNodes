<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmssTable extends Migration
{
    public function up()
    {
        Schema::create('smss', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->date('date_to_send')->nullable();
            $table->time('time_to_send')->nullable();
            $table->boolean('sent_to_men')->default(0)->nullable();
            $table->boolean('sent_to_woman')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
