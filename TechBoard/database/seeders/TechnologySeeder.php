<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Technology;
use App\Traits\LoadsSeederData;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    use LoadsSeederData;

    /**
     * 技術スタックデータのシード
     */
    public function run(): void
    {
        // マスターデータを読み込む
        $technologies = $this->loadData('master/technologies.json');

        // データ登録
        foreach ($technologies as $technologyData) {
            Technology::create($technologyData);
        }
    }
}
