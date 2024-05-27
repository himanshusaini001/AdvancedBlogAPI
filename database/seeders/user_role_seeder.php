<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\user_role;
use Illuminate\Support\Facades\File;

class user_role_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        user_role::create([
            'role_type'=>'Admin'
        ]);

        user_role::create([
            'role_type'=>'Author'
        ]);

        user_role::create([
            'role_type'=>'Reader'
        ]);
    }
}
