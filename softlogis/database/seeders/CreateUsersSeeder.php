<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run(): void
     {
         $users = [
             [
                 'uuid' => Str::uuid(),
                 'code' => Refgenerate(User::class, 'COL', 'code'),
                 'name' => 'Admin',
                 'lastname' => 'Illimitis',
                 'email' => 'admin@illimitis.ci',
                 'avatar' => 'default-logo.jpg',
                 'etat' => 'actif',
                 'phone' => '00000000',
                 'type' => '0',
                 'password' => bcrypt('123456'),
             ],
         ];

         foreach ($users as $key => $user) {
             User::create($user);
         }
     }
}
