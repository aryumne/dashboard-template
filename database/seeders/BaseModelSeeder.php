<?php

namespace Database\Seeders;

use App\Models\BaseModel;
use Illuminate\Database\Seeder;

class BaseModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'Air Flight 89',
            'Air Flight 89 Kids',
            'Air Flight Lite Mid',
            'Air Max Command',
            'Air Max Correlate',
            'Air Max Ivo',
            'Air Max Plus',
            'Air Max Plus Drift',
            'Air Max Plus Drift Kids',
            'Air Max Plus Kids',
            'Air Max SC',
            'Air Trainer 1',
            'AL8',
            'Alpha Trainer 6',
            'City Rep',
            'Cortez',
            'Cortez Kids',
            'DayBreak',
            'Defyallday',
            'Dunk low',
            'Dunk low Kids',
            'Flex runner 3 Kids',
            'Flight Legacy',
            'Huarache Run 2.0 Kids',
            'In Season 13',
            'INTRLK LITE',
            'Reax 8',
            'Revolution 5',
            'Revolution 6',
            'Revolution 6 Kids',
            'Revolution 7',
            'Revolution 7 Kids',
            'Runinspo',
            'Shox R4',
            'Shox R4 Kids',
            'Shox Ride 2',
            'Venture Runner',
            'Waffle Trainer 2',
            'Zoom 2K'
        ];

        foreach ($models as $mdl) {
            BaseModel::create(['name' => ucfirst($mdl)]);
        }
    }
}
