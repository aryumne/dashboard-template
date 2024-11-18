<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seasons = [
            'SP25',
            'SU25',
            'FA25',
            'HO25',
            'SP26',
            'SU26',
            'FA26',
            'HO26',
            'SP27',
            'SU27',
            'FA27',
            'HO27',
            'SP28',
            'SU28',
            'FA28',
            'HO28',
            'SP29',
            'SU29',
            'FA29',
            'HO29',
            'SP30',
            'SU30',
            'FA30',
            'HO30',
        ];

        foreach ($seasons as $ssn) {
            Season::create(['name' => strtoupper($ssn)]);
        }
    }
}
