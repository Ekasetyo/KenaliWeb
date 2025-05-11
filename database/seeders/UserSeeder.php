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
            'name' => 'Abi Ganteng',
            'email' => 'Abi@example.com',
            'password' => Hash::make('123password'),
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '2000-01-09',
            'no_telepon' => '081234567888',
            'alamat' => 'Jl. Contoh',
            'status' => 'user',
        ]);
    }
}
