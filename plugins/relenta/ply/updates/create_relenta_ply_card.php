<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyCard extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_card', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('card_id')->unsigned();
            $table->integer('course_id')->unsigned()->index('card_course')->default(0);
            $table->foreign('course_id', 'card_course_ref')->references('course_id')->on('relenta_ply_course')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('unit_id')->nullable()->index('card_unit')->unsigned()->default(0);
            $table->foreign('unit_id', 'card_unit_ref')->references('unit_id')->on('relenta_ply_unit')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('card_type')->unsigned()->default(0);
            $table->integer('card_sort')->unsigned()->default(0);
            $table->text('card_title');
            $table->mediumtext('card_data');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_card');
    }
}
