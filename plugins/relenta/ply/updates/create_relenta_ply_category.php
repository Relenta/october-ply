<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyCategory extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_category', function($table)
        {
            $table->increments('category_id')->unsigned();
            $table->integer('parent_id')->unsigned()->index('category_parent')->default(0);
            $table->foreign('parent_id', 'category_parent_ref')->references('category_id')->on('relenta_ply_category')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('category_sort')->unsigned()->index()->default(0);
            $table->text('category_title');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_category');
    }
}
