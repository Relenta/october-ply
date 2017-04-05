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
            $table->increments('course_id')->unsigned();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->integer('author_id')->unsigned()->index('course_author')->nullable()->default(0);
            //$table->foreign('author_id')->references('user_id')->on('users');
            $table->integer('category_id')->unsigned()->index('course_category')->nullable()->default(0);
            $table->foreign('category_id', 'course_category_ref')->references('category_id')->on('relenta_ply_category')->onUpdate('cascade')->onDelete('set null');
            $table->char('lang', 5)->default('');
            $table->text('course_title')->default('');
            $table->mediumtext('course_data')->default('');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('relenta_ply_course');
    }
}
