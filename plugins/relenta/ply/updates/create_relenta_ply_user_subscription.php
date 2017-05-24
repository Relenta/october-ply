<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyUserSubscription extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_user_subscription', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->integer('user_id')->unsigned()->index('course_subscriber');
            $table->integer('course_id')->unsigned()->index('course');

            $table->float('subscribed_at')->unsigned();
            // perspective to add price and etc.

            $table->foreign('user_id', 'user_ref')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('course_id', 'course_ref')
                ->references('id')
                ->on('relenta_ply_course')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('relenta_ply_user_subscription');
    }
}
