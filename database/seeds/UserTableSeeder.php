<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\User::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $user = \App\User::create([
            "name" => "Admin",
            "email" => "admin@gmail.com",
            "email_verified_at" => date("Y-m-d H:i:s"),
            "password" => "Password123#",
            "slug" => "admin"
        ]);

        $user->assignRole("admin");
    }
}
