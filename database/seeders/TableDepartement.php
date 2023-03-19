<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Departement;

class TableDepartement extends Seeder
{
    public function run()
    {
        $departement = [
            ['name'=>'House Keeping'],
            ['name'=>'TI'],
        ];
        foreach($departement as $row)
        {
            Departement::create($row);
        }
    }
}
