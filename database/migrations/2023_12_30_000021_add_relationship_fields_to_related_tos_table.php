<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRelatedTosTable extends Migration
{
    public function up()
    {
        Schema::table('related_tos', function (Blueprint $table) {
            $table->unsignedBigInteger('initial_contact_id')->nullable();
            $table->foreign('initial_contact_id', 'initial_contact_fk_9296371')->references('id')->on('users');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_9296376')->references('id')->on('teams');
        });
    }
}
