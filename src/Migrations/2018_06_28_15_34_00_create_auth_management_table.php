<?php

namespace Vongola\Auth\Migrations;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthManagementTable extends Migration
{

    public function up()
    {
        Schema::create('auth_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_type');
            $table->unsignedInteger('user_id');
            $table->string('user_agent');
            $table->string('login_ip');
            $table->string('session_id');
            $table->timestamp('last_activity_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('auth_records');
    }

}