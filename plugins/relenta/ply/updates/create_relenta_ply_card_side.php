<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyCardSide extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_card_side', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('card_side_id')->unsigned();
            $table->integer('card_id')->unsigned()->index('card_side_card')->default(0);
            $table->foreign('card_id', 'card_side_card_ref')->references('card_id')->on('relenta_ply_card')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('side_number')->nullable()->unsigned()->default(1);
            $table->mediumtext('side_data');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_card_side');
    }
}
