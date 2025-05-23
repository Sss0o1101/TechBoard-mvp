<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧を表示
     */
    public function index(): View
    {
        // ログインユーザーのお気に入り一覧を取得
        /** @var User $user */
        $user = Auth::user();
        $favorites = $user->favorites()
            ->with(['jobListing' => function($query) {
                $query->with(['jobType', 'prefecture', 'technologies', 'industry']);
            }])
            ->latest() // 新しい順に並べ替え
            ->paginate(10);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * お気に入りに追加
     */
    public function store(JobListing $jobListing): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        // 既にお気に入りに登録されていないか確認
        if ($user->hasFavorited($jobListing)) {
            return back()->with('info', 'この求人は既にお気に入りに登録されています');
        }

        // お気に入りに追加
        $user->favorites()->create([
            'job_listing_id' => $jobListing->id,
        ]);

        return back()->with('success', '求人をお気に入りに追加しました');
    }

    /**
     * お気に入りから削除
     */
    public function destroy(JobListing $jobListing): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        // お気に入りから削除
        $user->favorites()
            ->where('job_listing_id', $jobListing->id)
            ->delete();

        return back()->with('success', '求人をお気に入りから削除しました');
    }

    /**
     * お気に入りコメントの更新（Ajax処理）
     */
    public function updateComment(Request $request, JobListing $jobListing)
    {
        // リクエストデータのバリデーション
        $request->validate([
            'comment' => 'nullable|string|max:1000',
        ]);

        /** @var User $user */
        $user = Auth::user();
        // お気に入り情報を取得
        $favorite = $user->favorites()
            ->where('job_listing_id', $jobListing->id)
            ->firstOrFail();

        // コメントの有無を確認
        $hadComment = !is_null($favorite->comment);
        $hasNewComment = !is_null($request->comment) && trim($request->comment) !== '';

        // コメントがある場合は更新、ない場合は削除
        if ($hasNewComment) {
            $favorite->update([
                'comment' => $request->comment,
                'commented_at' => now(), // コメント日時を更新
            ]);
            $message = 'コメントを保存しました';
        } else {
            $favorite->update([
                'comment' => null,
                'commented_at' => null, // コメント日時をクリア
            ]);
            $message = 'コメントを削除しました';
        }

        // Ajax リクエストの場合はJSON形式で返す
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'favorite' => $favorite,
                'had_comment' => $hadComment,
                'has_comment' => $hasNewComment,
            ]);
        }

        // 通常のフォーム送信の場合はリダイレクト
        return back()->with('success', $message);
    }
}
