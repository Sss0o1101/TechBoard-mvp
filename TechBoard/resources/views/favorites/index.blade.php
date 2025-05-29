<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('お気に入り求人') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- フラッシュメッセージ -->
            <x-flash-message />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">お気に入りした求人一覧</h3>

                    @if ($favorites->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">まだお気に入りの求人がありません</p>
                            <a href="{{ route('jobs.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                                求人を探す
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($favorites as $favorite)
                                <div class="favorite-card border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow" data-favorite-id="{{ $favorite->id }}" data-job-id="{{ $favorite->jobListing->id }}">
                                    <div class="p-4">
                                        <!-- 求人タイトルと会社名 -->
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="text-lg font-semibold">{{ $favorite->jobListing->title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $favorite->jobListing->company_name }}</p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <!-- コメント編集ボタン -->
                                                <button type="button" class="edit-comment-btn text-blue-500 hover:text-blue-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>

                                                <!-- お気に入り解除ボタン -->
                                                <form action="{{ route('favorites.destroy', $favorite->jobListing) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <!-- 詳細ボタン -->
                                                <a href="{{ route('jobs.show', $favorite->jobListing) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    詳細
                                                </a>
                                            </div>
                                        </div>

                                        <!-- 技術スタック -->
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach ($favorite->jobListing->technologies as $technology)
                                                <span class="bg-gray-200 px-2 py-1 text-xs rounded">{{ $technology->name }}</span>
                                            @endforeach
                                        </div>

                                        <!-- 求人情報 -->
                                        <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                                            <div>
                                                <span class="font-medium text-gray-700">職種:</span>
                                                <span>{{ $favorite->jobListing->jobType->name }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">勤務地:</span>
                                                <span>{{ $favorite->jobListing->prefecture->name }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">雇用形態:</span>
                                                <span>{{ $favorite->jobListing->employment_type }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">給与:</span>
                                                <span>{{ $favorite->jobListing->salary_range }}</span>
                                            </div>
                                        </div>

                                        <!-- コメントエリア（コメントがある場合のみ表示） -->
                                        @if ($favorite->comment)
                                            <div class="comment-area mt-3 pt-3 border-t border-gray-200">
                                                <div class="flex items-center text-sm text-gray-500 mb-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                    </svg>
                                                    <span>メモ</span>
                                                    <span class="ml-auto text-xs">{{ $favorite->commented_at->format('Y年m月d日 H:i') }}</span>
                                                </div>
                                                <p class="text-sm whitespace-pre-line">{{ $favorite->comment }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- ページネーション -->
                        <div class="mt-6">
                            {{ $favorites->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- コメント編集モーダル -->
    <div id="commentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2" id="modal-title">
                            メモを追加・編集
                        </h3>
                        <p id="modal-job-title" class="text-sm font-medium"></p>
                        <p id="modal-company-name" class="text-sm text-gray-500 mb-4"></p>

                        <div class="mt-2">
                            <textarea id="commentText" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="saveCommentBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    保存する
                </button>
                <button type="button" id="cancelCommentBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    キャンセル
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
