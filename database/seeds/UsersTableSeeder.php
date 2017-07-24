<?php

use App\User;
use App\Phone;
use App\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Position::class, 2)->create();
        factory(User::class)->create(['password' => bcrypt('qwerty'), 'role_id' => 1]);
        factory(User::class, 300)->create(['password' => Hash::make('qwerty')]);
        factory(Phone::class, 800)->create();
    }
}
