<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyUnit extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_unit', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->nullable()->unsigned()->index('unit_parent');
            $table->foreign('parent_id', 'unit_parent_ref')->references('id')->on('relenta_ply_unit')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->index('unit_course')->default(0);
            $table->foreign('course_id', 'unit_course_ref')->references('id')->on('relenta_ply_course')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('sort')->unsigned()->default(0);
            $table->text('title');
            $table->string('slug')->nullable()->index()->unique();
            $table->mediumtext('data');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_unit');
    }
}
