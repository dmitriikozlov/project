<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\User();

        $admin->name = "admin";
        $admin->email = "admin@gmail.com";
        $admin->password = "admin";
        $admin->role = "admin";

        $admin->save();
    }
}
