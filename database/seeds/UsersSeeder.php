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
            'name' => 'Admin',
            'email' => 'test@test.ru',
            'password' => Hash::make('admins'),
            'group' => 'admin',
        ));
    }
}
