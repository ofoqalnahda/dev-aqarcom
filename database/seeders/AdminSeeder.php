<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user= Admin::create([
            'name'=>'admin',
            'email'=>'admin@app.com'
            ,'password'=>bcrypt('12345678')

        ]);

        $role = Role::findOrCreate('super_admin');
        $user->assignRole([$role->id]);




    }
}
