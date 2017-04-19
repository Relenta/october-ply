<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRelentaPlyCategory extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_category', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->unsigned()->index('category_parent')->nullable();
            $table->foreign('parent_id', 'category_parent_ref')->references('id')->on('relenta_ply_category')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('sort')->unsigned()->index()->default(0);
            $table->text('title');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_category');
    }
}
