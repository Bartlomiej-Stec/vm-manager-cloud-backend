<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count() != 0){
            return;
        }
        $user = User::create([
            'name' => config('manager.default_name'),
            'email' => config('manager.default_email'),
            'password' => Hash::make(config('manager.default_password')),
            'surname' => config('manager.default_surname')
        ]);
        $user->assignRole('manager');
    }
}
