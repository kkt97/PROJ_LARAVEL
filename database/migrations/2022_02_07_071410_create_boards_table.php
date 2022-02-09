<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->text('content');

            $table->text('image_name')->nullable();

            $table->text('image_path')->nullable();

            $table->unsignedBigInteger('user_id')->comment('')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->nullable();

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
        Schema::table('boards', function (Blueprint $table) {
            $table->dropForeign('boards_user_id_foreign');
        });

        Schema::dropIfExists('boards');
    }
}
