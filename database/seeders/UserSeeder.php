<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Kenali',
            'email' => 'AdminKenali@gmail.com',
            'password' => Hash::make('AdminKenali123'),
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2000-01-09',
            'no_telepon' => '081234567888',
            'alamat' => 'Jl. Contoh',
            'status' => 'admin',
        ]);

        User::create([
            'name' => 'User Kenali',
            'email' => 'UserKenali@gmail.com',
            'password' => Hash::make('UserKenali123'),
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2000-01-10',
            'no_telepon' => '081234569981',
            'alamat' => 'Jl. polije',
            'status' => 'user',
        ]);
    }
}
