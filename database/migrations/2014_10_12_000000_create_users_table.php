<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_id', '15')->unique()->comment('아이디'); // 추가함
            $table->unsignedSmallInteger('user_level')->comment('권한'); // 추가함
            $table->string('email', '30')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', '12'); // 추가함
            $table->string('password','20');
            $table->string('address', '300');
            $table->string('code', '10');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
