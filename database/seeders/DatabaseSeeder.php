<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\UserTypeEnums;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'business',
            'email' => 'business@demo.com',
            'password' => 'business',
            'account_type' => UserTypeEnums::business(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'individual',
            'email' => 'individual@demo.com',
            'password' => 'individual',
            'account_type' => UserTypeEnums::individual(),
            'remember_token' => Str::random(10),
        ]);
    }
}
