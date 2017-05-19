<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyUserFlashCard extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_user_flashcard', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->index('card_user')->default(0);
            $table->integer('card_id')->nullable()->index('card')->unsigned()->default(0);
            $table->float('days_between_reviews')->unsigned()->default(0);
            $table->float('difficulty')->unsigned()->default(0);
            $table->date('last_time')->nullable();


            $table->foreign('user_id', 'card_user_ref')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('card_id', 'card_ref')
                ->references('id')
                ->on('relenta_ply_card')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('relenta_ply_user_flashcard');
    }
}
