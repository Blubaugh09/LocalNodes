<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactedsTable extends Migration
{
    public function up()
    {
        Schema::create('contacteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contact_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
