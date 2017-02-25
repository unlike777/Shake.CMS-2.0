<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->truncate();
        DB::table('regs')->truncate();
        DB::table('settings')->truncate();
        
        $this->call(PagesSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
