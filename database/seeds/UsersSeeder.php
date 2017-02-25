<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
    
        DB::table('users')->truncate();
    
        User::create(array(
            'email' => 'test@test.ru',
            'password' => 'admins',
            'group' => 'admin',
        ));
    }
}
