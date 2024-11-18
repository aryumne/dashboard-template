<?php

namespace Database\Seeders;

use App\Models\TdCode;
use Illuminate\Database\Seeder;

class TdCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codes = [
            'F4',
            'F3',
            'F2',
            'F1',
            'N4',
            'N3',
            'N2',
            'N1'
        ];

        foreach ($codes as $tdc) {
            TdCode::create(['name' => strtoupper($tdc)]);
        }
    }
}
