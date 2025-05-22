<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Industry;
use App\Traits\LoadsSeederData;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    use LoadsSeederData;

    /**
     * 業界データのシード
     */
    public function run(): void
    {
        // マスターデータを読み込む
        $industries = $this->loadData('master/industries.json');

        // データ登録
        foreach ($industries as $industryData) {
            Industry::create($industryData);
        }
    }
}
