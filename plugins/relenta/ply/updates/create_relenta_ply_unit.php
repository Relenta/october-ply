<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyUnit extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_unit', function($table)
        {
            $table->increments('unit_id')->unsigned();
            $table->integer('parent_id')->unsigned()->index('unit_parent')->default(0);
            $table->foreign('parent_id', 'unit_parent_ref')->references('unit_id')->on('relenta_ply_unit')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->index('unit_course')->default(0);
            $table->foreign('course_id', 'unit_course_ref')->references('course_id')->on('relenta_ply_course')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('unit_sort')->unsigned()->default(0);
            $table->text('title');
            $table->mediumtext('unit_data');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_unit');
    }
}
