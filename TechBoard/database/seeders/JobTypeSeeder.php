<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\JobType;
use App\Traits\LoadsSeederData;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    use LoadsSeederData;

    /**
     * 職種データのシード
     */
    public function run(): void
    {
        // マスターデータを読み込む
        $jobTypes = $this->loadData('master/job_types.json');

        // データ登録
        foreach ($jobTypes as $jobTypeData) {
            JobType::create($jobTypeData);
        }
    }
}
