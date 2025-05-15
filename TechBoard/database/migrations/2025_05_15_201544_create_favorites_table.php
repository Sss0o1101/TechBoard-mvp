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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); //ユーザー削除時にお気に入りデータも削除
            $table->foreignId('job_listing_id')->constrained()->cascadeOnDelete(); //求人削除時にお気に入りデータも削除
            $table->text('comment')->nullable(); //コメント
            $table->timestamp('commented_at')->nullable(); //コメント日時
            $table->timestamps();

            $table->unique(['user_id', 'job_listing_id']); //同じユーザーが同じ求人をお気に入りに登録することはできない

            $table->index('commented_at'); //コメント有無でのフィルタリング用
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
