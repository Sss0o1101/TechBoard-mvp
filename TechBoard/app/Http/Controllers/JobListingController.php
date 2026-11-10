<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobType;
use App\Models\Prefecture;
use App\Models\Technology;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobListingController extends Controller
{
    /**
     * 求人一覧・検索ページを表示
     */
    public function index(Request $request): View
    {
        // 求人データを取得（リレーションをEager Loading）
        $query = JobListing::with(['jobType', 'prefecture', 'technologies', 'industry']);

        // 検索フィルタリング：キーワード
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")->orWhere('description', 'like', "%{$keyword}%")->orWhere('company_name', 'like', "%{$keyword}%");
            });
        }

        // 検索フィルタリング：地域/勤務地
        if ($request->filled('prefecture_id')) {
            $query->where('prefecture_id', $request->prefecture_id);
        }

        // 検索フィルタリング：職種
        if ($request->filled('job_type_id')) {
            $query->where('job_type_id', $request->job_type_id);
        }

        // 検索フィルタリング：技術スタック
        if ($request->filled('technology_id')) {
            $query->whereHas('technologies', function($q) use ($request) {
                $q->where('technology_id', $request->technology_id);
            });
        }

        // 検索フィルタリング：未経験可否
        if ($request->filled('is_inexperienced_ok')) {
            $isInexperiencedOk = $request->is_inexperienced_ok === 'yes';
            $query->where('is_inexperienced_ok', $isInexperiencedOk);
        }

        // 検索フィルタリング：リモート可否
        if ($request->filled('is_remote_ok')) {
            $isRemoteOk = $request->is_remote_ok === 'yes';
            $query->where('is_remote_ok', $isRemoteOk);
        }

        // 検索フィルタリング：雇用形態
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        // 検索フィルタリング：最低給与
        if ($request->filled('min_salary')) {
            $query->where('min_salary', '>=', $request->min_salary);
        }

        // 検索フィルタリング：最高給与
        if ($request->filled('max_salary')) {
            $query->where('max_salary', '<=', $request->max_salary);
        }

        // 検索フィルタリング：業界
        if ($request->filled('industry_id')) {
            $query->where('industry_id', $request->industry_id);
        }

        // 並び順
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('order', 'desc');

        // 許可されたソートフィールドのみを使用（セキュリティ対策）
        if (in_array($sortField, ['created_at', 'min_salary', 'max_salary'])) {
            $query->orderBy($sortField, $sortOrder);
        }

        // ページネーション（クエリストリングを保持）
        $jobs = $query->paginate(10)->withQueryString();

        // 検索フォーム用のデータを取得
        $prefectures = Prefecture::orderBy('id')->get();
        $jobTypes = JobType::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();
        $industries = Industry::orderBy('name')->get();
        $employmentTypes = ['正社員', '契約社員', '派遣社員', 'アルバイト・パート', '業務委託'];

        return view('jobs.index', compact(
            'jobs', 'prefectures', 'jobTypes', 'technologies',
            'industries', 'employmentTypes'
        ));
    }

    /**
     * 求人詳細ページを表示
     */
    public function show(JobListing $jobListing): View
    {
        // リレーションを事前に読み込む（N+1問題を防ぐ）
        $jobListing->load(['jobType', 'prefecture', 'technologies', 'industry']);

        return view('jobs.show', compact('jobListing'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
