<?php

namespace Database\Seeders;

use App\Models\JobListing;
use App\Models\Technology;
use App\Traits\LoadsSeederData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;     //\DB::transactionではなく、DB::transactionを使用

class JobListingSeeder extends Seeder
{
    use LoadsSeederData;

    /**
     * 求人データのシード
     */
    public function run(): void
    {
        // jobsディレクトリからすべてのJSONファイルのデータを読み込む
        $jobsData = $this->loadAllDataFromDirectory('jobs');

        // トランザクション内で処理する（一部が失敗した場合はロールバック）
        DB::transaction(function () use ($jobsData) {
            foreach ($jobsData as $jobData) {
                // すでに同じタイトル・会社名の求人が存在するかチェック
                $exists = JobListing::where('title', $jobData['title'])
                    ->where('company_name', $jobData['company_name'])
                    ->exists();

                // 重複しない場合のみ登録
                if (!$exists) {
                    // 技術スタックデータを抽出
                    $technologies = $jobData['technologies'] ?? [];
                    unset($jobData['technologies']);

                    // 求人情報の登録
                    $job = JobListing::create($jobData);

                    // 技術スタックの関連付け
                    if (!empty($technologies)) {
                        $techIds = Technology::whereIn('name', $technologies)->pluck('id');
                        $job->technologies()->attach($techIds);
                    }
                }
            }
        });
    }
}
