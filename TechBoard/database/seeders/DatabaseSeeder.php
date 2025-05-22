<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * データベースシーディングを実行
     */
    public function run(): void
    {
        // マスターデータを先に登録
        $this->call([
            PrefectureSeeder::class,
            JobTypeSeeder::class,
            TechnologySeeder::class,
            IndustrySeeder::class,
        ]);

        // 求人データを登録
        $this->call(JobListingSeeder::class);
    }
}
