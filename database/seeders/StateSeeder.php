<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'DBOM In-Work',
            'DBOM Released',
            'DBOM Update Complete',
            'DBOM Update Pending',
            'MBOM Confirmed',
            'MBOM Tentative',
        ];

        foreach ($states as $stt) {
            State::create(['name' => $stt]);
        }
    }
}
