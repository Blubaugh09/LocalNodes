<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCategoryUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('member_category_user', function (Blueprint $table) {
            $table->unsignedBigInteger('member_category_id');
            $table->foreign('member_category_id', 'member_category_id_fk_9349871')->references('id')->on('member_categories')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_9349871')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
