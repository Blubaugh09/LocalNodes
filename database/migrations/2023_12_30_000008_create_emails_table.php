<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('body');
            $table->date('date_to_send')->nullable();
            $table->time('time_to_send')->nullable();
            $table->boolean('sent_to_men')->default(0)->nullable();
            $table->boolean('sent_to_women')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
