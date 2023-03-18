<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use App\Models\Master\Staff;

class TableUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = DB::table('roles')->where('name', 'admin')->get()->first()->id;

        $user = Users::create([
            'role_id'   => $admin,
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'username'  => 'admin',
            'password'  => bcrypt('admin'),
        ]);
        
        Staff::create([
            'users_id' => $user->id,
            'nip' => '1234567890',
            'position_id' => 1,
            'departement_id' => 1,
            'name' => 'Tasrin Adiputra',
            'birth' => date('Y-m-d'),
            'startdate' => date('Y-m-d'),
            'address' => 'Makassar',
            'address' => null,
            'phone' => '081234567890',
        ]);
    }
}
