<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $appUrl = config('APP_URL', "http://paidigital.local");
        Schema::create('general_settings', function (Blueprint $table) use ($appUrl){
            $table->uuid('id')->primary();
            $table->string("brand_name")->default("NetPublik");
            $table->string("brand_logo")->default("$appUrl/logo.svg");
            $table->text("keywords")->nullable();
            $table->text("short_desc")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
