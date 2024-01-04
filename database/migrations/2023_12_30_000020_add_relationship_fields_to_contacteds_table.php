<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToContactedsTable extends Migration
{
    public function up()
    {
        Schema::table('contacteds', function (Blueprint $table) {
            $table->unsignedBigInteger('user_started_id')->nullable();
            $table->foreign('user_started_id', 'user_started_fk_9296362')->references('id')->on('users');
            $table->unsignedBigInteger('user_ended_id')->nullable();
            $table->foreign('user_ended_id', 'user_ended_fk_9296363')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9296368')->references('id')->on('teams');
        });
    }
}
