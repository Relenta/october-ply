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

            $table->integer('user_id')->unsigned()->index('course_subscriber');
            $table->integer('course_id')->unsigned()->index('course');

            $table->integer('subscribed_at')->unsigned();
            $table->integer('subscription_expires_at')->unsigned();
            // perspective to add price and etc.

            $table->primary(['user_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('relenta_ply_user_subscription');
    }
}
