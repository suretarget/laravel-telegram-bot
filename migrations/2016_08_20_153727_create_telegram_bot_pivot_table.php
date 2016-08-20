<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramBotPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_bot_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telegram_bot_user_id')->unsigned()->index();
            $table->integer('telegram_bot_permission_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('telegram_bot_user_id')
                  ->references('id')
                  ->on('telegram_bot_users')
                  ->onDelete('cascade');

            $table->foreign('telegram_bot_permission_id')
                  ->references('id')
                  ->on('telegram_bot_permissions')
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
        Schema::drop('telegram_bot_pivot');
    }
}
