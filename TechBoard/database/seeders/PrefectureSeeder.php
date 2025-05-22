<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Prefecture;
use App\Traits\LoadsSeederData;
use Illuminate\Database\Seeder;

class PrefectureSeeder extends Seeder
{
    use LoadsSeederData;

    /**
     * 都道府県データのシード
     */
    public function run(): void
    {
        // マスターデータを読み込む
        $prefectures = $this->loadData('master/prefectures.json');

        // データ登録
        foreach ($prefectures as $prefectureData) {
            Prefecture::create($prefectureData);
        }
    }
}
