<?php

use Illuminate\Database\Seeder;
use App\Modules\Users\Models\User;

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
            'password' => 'admins',
            'group' => 'admin',
        ));
    }
}
