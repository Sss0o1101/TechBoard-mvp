<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('求人を探す') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- フラッシュメッセージ -->
            <x-flash-message />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- 検索フォーム -->
                    <form method="GET" action="{{ route('jobs.index') }}" class="search-form mb-8">
                        <div class="search-container bg-white rounded-lg shadow-md p-4">
                            <!-- キーワード検索 -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">キーワード</label>
                                <input type="text" name="keyword" value="{{ request('keyword') }}"
                                    class="w-full mt-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- セクション区切り -->
                            <div class="my-4 border-t border-gray-200"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- 地域/勤務地 -->
                                <div class="mb-4">
                                    <label for="prefecture_id" class="block text-sm font-medium text-gray-700">地域/勤務地</label>
                                    <select id="prefecture_id" name="prefecture_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">すべての地域</option>
                                        @foreach($prefectures as $prefecture)
                                            <option value="{{ $prefecture->id }}" {{ request('prefecture_id') == $prefecture->id ? 'selected' : '' }}>
                                                {{ $prefecture->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 職種 -->
                                <div class="mb-4">
                                    <label for="job_type_id" class="block text-sm font-medium text-gray-700">職種</label>
                                    <select id="job_type_id" name="job_type_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">すべての職種</option>
                                        @foreach($jobTypes as $jobType)
                                            <option value="{{ $jobType->id }}" {{ request('job_type_id') == $jobType->id ? 'selected' : '' }}>
                                                {{ $jobType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 技術スタック -->
                                <div class="mb-4">
                                    <label for="technology_id" class="block text-sm font-medium text-gray-700">技術スタック</label>
                                    <select id="technology_id" name="technology_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">すべての技術</option>
                                        @foreach($technologies as $technology)
                                            <option value="{{ $technology->id }}" {{ request('technology_id') == $technology->id ? 'selected' : '' }}>
                                                {{ $technology->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 未経験可否 -->
                                <div class="mb-4">
                                    <label for="is_inexperienced_ok" class="block text-sm font-medium text-gray-700">未経験</label>
                                    <select id="is_inexperienced_ok" name="is_inexperienced_ok" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">指定なし</option>
                                        <option value="yes" {{ request('is_inexperienced_ok') === 'yes' ? 'selected' : '' }}>未経験可</option>
                                        <option value="no" {{ request('is_inexperienced_ok') === 'no' ? 'selected' : '' }}>経験者のみ</option>
                                    </select>
                                </div>

                                <!-- リモート可否 -->
                                <div class="mb-4">
                                    <label for="is_remote_ok" class="block text-sm font-medium text-gray-700">リモートワーク</label>
                                    <select id="is_remote_ok" name="is_remote_ok" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">指定なし</option>
                                        <option value="yes" {{ request('is_remote_ok') === 'yes' ? 'selected' : '' }}>リモート可</option>
                                        <option value="no" {{ request('is_remote_ok') === 'no' ? 'selected' : '' }}>オフィスのみ</option>
                                    </select>
                                </div>

                                <!-- 雇用形態 -->
                                <div class="mb-4">
                                    <label for="employment_type" class="block text-sm font-medium text-gray-700">雇用形態</label>
                                    <select id="employment_type" name="employment_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">すべての雇用形態</option>
                                        @foreach($employmentTypes as $type)
                                            <option value="{{ $type }}" {{ request('employment_type') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 最低給与 -->
                                <div class="mb-4">
                                    <label for="min_salary" class="block text-sm font-medium text-gray-700">最低給与</label>
                                    <select id="min_salary" name="min_salary" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">指定なし</option>
                                        @foreach([300, 400, 500, 600, 700, 800] as $value)
                                            <option value="{{ $value }}" {{ request('min_salary') == $value ? 'selected' : '' }}>
                                                {{ $value }}万円〜
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 最高給与 -->
                                <div class="mb-4">
                                    <label for="max_salary" class="block text-sm font-medium text-gray-700">最高給与</label>
                                    <select id="max_salary" name="max_salary" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">指定なし</option>
                                        @foreach([400, 500, 600, 700, 800, 1000, 1200] as $value)
                                            <option value="{{ $value }}" {{ request('max_salary') == $value ? 'selected' : '' }}>
                                                〜{{ $value }}万円
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- 業界 -->
                                <div class="mb-4">
                                    <label for="industry_id" class="block text-sm font-medium text-gray-700">業界</label>
                                    <select id="industry_id" name="industry_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">すべての業界</option>
                                        @foreach($industries as $industry)
                                            <option value="{{ $industry->id }}" {{ request('industry_id') == $industry->id ? 'selected' : '' }}>
                                                {{ $industry->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <a href="{{ route('jobs.index') }}" class="mr-4 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    クリア
                                </a>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    検索する
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- 検索結果ステータス -->
                    <div class="mb-4 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            {{ $jobs->total() }}件中 {{ $jobs->firstItem() ?? 0 }}〜{{ $jobs->lastItem() ?? 0 }}件表示
                        </div>

                        <!-- ソート機能 -->
                        <div class="text-sm">
                            <span class="mr-2">並び順:</span>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => 'desc']) }}"
                               class="{{ (request('sort', 'created_at') == 'created_at' && request('order', 'desc') == 'desc') ? 'font-bold text-blue-600' : 'text-gray-600' }}">
                                新着順
                            </a>
                            <span class="mx-1">|</span>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'min_salary', 'order' => 'desc']) }}"
                               class="{{ (request('sort') == 'min_salary' && request('order') == 'desc') ? 'font-bold text-blue-600' : 'text-gray-600' }}">
                                給与高い順
                            </a>
                        </div>
                    </div>

                    <!-- 求人カード一覧 -->
                    <div class="space-y-4 mt-6">
                        @forelse ($jobs as $job)
                            <div class="border p-4 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $job->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $job->company_name }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        @auth
                                            @if (auth()->user()->hasFavorited($job))
                                                <form action="{{ route('favorites.destroy', $job) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('favorites.store', $job) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth

                                        <a href="{{ route('jobs.show', $job) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                                            詳細
                                        </a>
                                    </div>
                                </div>

                                <!-- 技術スタック -->
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($job->technologies as $technology)
                                        <span class="bg-gray-200 px-2 py-1 text-xs rounded">{{ $technology->name }}</span>
                                    @endforeach
                                </div>

                                <!-- 求人情報 -->
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2">
                                    <div class="flex items-center text-sm">
                                        <span class="font-medium mr-2">勤務地:</span>
                                        <span>{{ $job->prefecture->name }} {{ $job->location }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <span class="font-medium mr-2">職種:</span>
                                        <span>{{ $job->jobType->name }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <span class="font-medium mr-2">雇用形態:</span>
                                        <span>{{ $job->employment_type }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <span class="font-medium mr-2">給与:</span>
                                        <span>{{ $job->salary_range }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <span class="font-medium mr-2">業界:</span>
                                        <span>{{ $job->industry->name ?? '未設定' }}</span>
                                    </div>
                                    <div class="flex items-center text-sm gap-2">
                                        @if($job->is_inexperienced_ok)
                                            <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs">未経験可</span>
                                        @endif
                                        @if($job->is_remote_ok)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs">リモート可</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 bg-white rounded-lg shadow">
                                <p class="text-gray-500">条件に一致する求人が見つかりませんでした</p>
                                <p class="text-sm text-gray-400 mt-1">検索条件を変更して再度お試しください</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- ページネーション -->
                    <div class="mt-6">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
