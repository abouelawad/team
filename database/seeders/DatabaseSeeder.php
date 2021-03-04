<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $roles = ['admin','teacher' , 'student','support','secretary' ];
        foreach($roles as $role){
            Role::create([
                'name' => $role
            ]);
        }

        User::create([
            'name' => 'admin',
            'email' => 'admin@a.com',
            'password' => Hash::make('123456'),
            'phone' => '123456',
            'status' => '0',
            'role_id' => '1',

        ]);
        User::create([
            'name' => 'student',
            'email' => 'student@a.com',
            'password' => Hash::make('123456'),
            'phone' => '123456',
            'status' => '0',
            'role_id' => 3,

        ]);
        // User::factory(10)->create();
    }
}
