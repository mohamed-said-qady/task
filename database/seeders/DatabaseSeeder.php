<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

         User::factory()->create([
            'name' => 'mohamed said',
            'password'  => Hash::make('k6c12602##'),
            'email' => 'mhmdqady730@gmail.com',
         ]);
    }
}
