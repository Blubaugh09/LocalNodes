<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleSmsPivotTable extends Migration
{
    public function up()
    {
        Schema::create('role_sms', function (Blueprint $table) {
            $table->unsignedBigInteger('sms_id');
            $table->foreign('sms_id', 'sms_id_fk_9351083')->references('id')->on('smss')->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_9351083')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
