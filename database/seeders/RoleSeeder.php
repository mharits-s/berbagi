<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $fundraiserRole = Role::create([
            'name' => 'fundraiser'
        ]);

        $userOwner = User::create([
            'name' => 'Muhammad Harits',
            'avatar' => 'images/7573doodle.png',
            'email' => 'harits@berbagi.com',
            'password' => bcrypt('123321')

        ]);

        $userOwner->assignRole($ownerRole);
    }
}
