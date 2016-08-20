<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramBotUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_bot_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telegram_bot_id')->unsigned()->index();
            $table->integer('chat_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->timestamps();

            $table->foreign('telegram_bot_id')
                  ->references('id')
                  ->on('telegram_bots')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('telegram_bot_users');
    }
}
