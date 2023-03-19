<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Position;

class TablePosition extends Seeder
{
    public function run()
    {
        $position = [
            ['name'=>'Supervisor', 'status'=>'Staff', 'salary'=>3500000],
            ['name'=>'Magang', 'status'=>'Daily Worker', 'salary'=>2000000],

        ];
        foreach($position as $row)
        {
            Position::create($row);
        }
    }
}
