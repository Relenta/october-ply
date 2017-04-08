<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use DB;

class CreateRelentaPlyCourse extends Migration
{
    public function up()
    {
        Schema::create('relenta_ply_course', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->integer('author_id')->unsigned()->index('course_author')->nullable()->default(0);
            //$table->foreign('author_id')->references('user_id')->on('users');
            $table->integer('category_id')->unsigned()->index('course_category')->nullable()->default(0);
            $table->foreign('category_id', 'course_category_ref')->references('id')->on('relenta_ply_category')->onUpdate('cascade')->onDelete('set null');
            $table->char('lang', 5)->default('');
            $table->text('title')->default('');
            $table->mediumtext('data')->default('');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_course');
    }
}
