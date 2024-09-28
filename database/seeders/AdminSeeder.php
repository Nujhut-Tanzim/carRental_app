<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Nujhat Tanzim',
            'email' => 'nujhattanzim@gmail.com',
            'password' => 'ab123',
            'phone'=>'01749535100',
            'address'=>'Amlapara,Pirojpur',
            'otp'=>'0',
            'role' => 'admin'
            
        ]);
    }
}
