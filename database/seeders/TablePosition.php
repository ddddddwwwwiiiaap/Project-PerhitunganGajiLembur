<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Position;

class TablePosition extends Seeder
{
    public function run()
    {
        $position = [
        ];
        foreach($position as $row)
        {
            Position::create($row);
        }
    }
}
