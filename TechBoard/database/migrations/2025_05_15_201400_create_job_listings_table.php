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
        Schema::create('job_listings', function (Blueprint $table) {

            // 基本情報
            $table->id();
            $table->string('title');                // 求人タイトル
            $table->text('description');            // 職務内容
            $table->string('company_name');         // 会社名

            // 外部キー
            $table->foreignId('job_type_id')->constrained()->onDelete('restrict');             // 職種ID     //職種は削除不可
            $table->foreignId('prefecture_id')->constrained()->onDelete('restrict');           // 都道府県ID  //都道府県は削除不可
            $table->foreignId('industry_id')->nullable()->constrained()->onDelete('set null'); // 業界ID  //業界は任意 //業界削除時はnullに

            // 追加情報
            $table->string('location')->nullable();                  // 勤務地詳細
            $table->integer('min_salary')->nullable();               // 最低給与
            $table->integer('max_salary')->nullable();               // 最高給与
            $table->string('employment_type');                       // 雇用形態
            $table->boolean('is_remote_ok')->default(false);         // リモート可否
            $table->boolean('is_inexperienced_ok')->default(false);  // 未経験可否

            $table->timestamps();

            // インデックス(検索効率化)
            $table->index('min_salary');
            $table->index('max_salary');
            $table->index('employment_type');
            $table->index('is_remote_ok');
            $table->index('is_inexperienced_ok');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
