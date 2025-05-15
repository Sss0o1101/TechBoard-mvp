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
        Schema::create('job_technology', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained()->cascadeOnDelete();  //求人削除時に中間データも削除
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();   //技術削除時に中間データも削除
            $table->timestamps();

            $table->unique(['job_listing_id', 'technology_id']); //同じ求人と技術の組み合わせは1つだけ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_technology');
    }
};
