<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedToUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('related_to_user', function (Blueprint $table) {
            $table->unsignedBigInteger('related_to_id');
            $table->foreign('related_to_id', 'related_to_id_fk_9296372')->references('id')->on('related_tos')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_9296372')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
