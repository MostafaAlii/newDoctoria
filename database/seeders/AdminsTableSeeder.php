<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\Admin::create([
            'name'  => 'Super Admin',
            'email'  => 'super_admin@app.com',
            'password' => bcrypt('password'),
        ]);
        $admin->addRole('super_admin');
    }
}
