<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->longText('notes')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->string('remember_token')->nullable();
            $table->date('birthday')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
