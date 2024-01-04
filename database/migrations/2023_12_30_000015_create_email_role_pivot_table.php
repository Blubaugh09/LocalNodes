<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailRolePivotTable extends Migration
{
    public function up()
    {
        Schema::create('email_role', function (Blueprint $table) {
            $table->unsignedBigInteger('email_id');
            $table->foreign('email_id', 'email_id_fk_9351084')->references('id')->on('emails')->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_9351084')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
