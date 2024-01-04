<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('mother_id')->nullable();
            $table->foreign('mother_id', 'mother_fk_9349794')->references('id')->on('users');
            $table->unsignedBigInteger('father_id')->nullable();
            $table->foreign('father_id', 'father_fk_9349795')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9296359')->references('id')->on('teams');
        });
    }
}
