<?php

namespace Database\Seeders;

use App\Enums\MarketEnum;
use App\Enums\StageEnum;
use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            [
                'name' => StageEnum::DesignReview,
                'code' => 'DR',
                'market' => MarketEnum::INLINE,
            ],
            [
                'name' => StageEnum::FirstAdoption,
                'code' => 'PA/PR',
                'market' => MarketEnum::INLINE,
            ],
            [
                'name' => StageEnum::FinalAdoption,
                'code' => 'GGP',
                'market' => MarketEnum::INLINE,
            ],
            [
                'name' => StageEnum::SalesSamples,
                'code' => 'SPA',
                'market' => MarketEnum::INLINE,
            ],
            [
                'name' => StageEnum::FirstRound,
                'code' => 'GEL',
                'market' => MarketEnum::GEL,
            ],
            [
                'name' => StageEnum::SecondRound,
                'code' => 'GEL',
                'market' => MarketEnum::GEL,
            ],
            [
                'name' => StageEnum::ProductionCFM,
                'code' => 'CFM',
                'market' => MarketEnum::ALL,
            ],
        ];

        foreach ($stages as $data) {
            Stage::create([
                'name' => $data['name'],
                'code' => $data['code'],
                'market' => $data['market'],
            ]);
        }
    }
}
