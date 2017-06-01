<?php namespace Relenta\Ply\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class RenameRelentaPlyUserFlashCard extends Migration
{
    public function up()
    {
        Schema::rename('relenta_ply_user_flashcard', 'relenta_ply_user_stats');
    }

    public function down()
    {
        Schema::rename('relenta_ply_user_stats', 'relenta_ply_user_flashcard');
    }
}
