<?php namespace Relenta\Ply\Updates;

use RainLab\User\Models\User;
use Relenta\Ply\Traits\Database\DisableForeignKeys;
use Seeder;

class SeedUsers extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();
        User::truncate();

        $user = new User([
            'id'                    => 1,
            'name'                  => 'Admin',
            'password'              => '1234',
            'password_confirmation' => '1234',
            'email'                 => 'admin@admin.com',
        ]);

        $user->save();
        $this->enableForeignKeys();
    }
}
