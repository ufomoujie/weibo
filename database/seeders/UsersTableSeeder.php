<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::factory(50)->create();

        $user = User::find(1);
        $user->name = 'mou';
        $user->email = 'mou@eazesystems.com';
        $user->password = bcrypt('ufo111111');
        $user->is_admin = true;
        $user->save();
    }
}
