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
            $table->increments('id')->unsigned();
            $table->integer('course_id')->unsigned()->index('card_course')->default(0);
            $table->foreign('course_id', 'card_course_ref')->references('id')->on('relenta_ply_course')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('unit_id')->nullable()->index('card_unit')->unsigned()->default(0);
            $table->foreign('unit_id', 'card_unit_ref')->references('id')->on('relenta_ply_unit')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('type')->unsigned()->default(0);
            $table->integer('sort')->unsigned()->default(0);
            $table->text('title');
            $table->mediumtext('data');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_card');
    }
}
