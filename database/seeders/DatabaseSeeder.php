<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ActivityLog;
use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\BaseModelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        GeneralSetting::create([
            'brand_name' => env("APP_NAME"),
            'brand_logo' => env("APP_URL") . '/' . env("APP_LOGO_NAME")
        ]);

        $this->call([
            UserSeeder::class,
        ]);

        ActivityLog::whereNull("causer_id")->delete();
    }
}
