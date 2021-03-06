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
            'email' => 'admin1@a.com',
            'password' => Hash::make('123456'),
            'phone' => '123456',
            'status' => '0',
            'role_id' => '1',

        ]);
        User::create([
            'name' => 'student',
            'email' => 'student1@a.com',
            'password' => Hash::make('123456'),
            'phone' => '123456',
            'status' => '0',
            'role_id' => 3,

        ]);
        User::create([
            'name' => 'teacher',
            'email' => 'teacher1@a.com',
            'password' => Hash::make('123456'),
            'phone' => '123456',
            'status' => '0',
            'role_id' => 2,

        ]);
        User::create([
            'name' => 'support',
            'email' => 'support@a.com',
            'password' => Hash::make('123456'),
            'phone' => '123456',
            'status' => '0',
            'role_id' => 4,

        ]);
        User::create([
            'name' => 'secretary',
            'email' => 'secretary@a.com',
            'password' => Hash::make('123456'),
            'phone' => '123456',
            'status' => '0',
            'role_id' => 4,

        ]);
        // User::factory(10)->create();
    }
}
