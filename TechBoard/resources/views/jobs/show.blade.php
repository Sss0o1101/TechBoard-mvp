<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $jobListing->title }}
            </h2>
            <a href="{{ url()->previous() === route('jobs.show', $jobListing) ? route('jobs.index') : url()->previous() }}"
               class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-sm">
                戻る
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex justify-between items-start">
                            <h1 class="text-2xl font-bold">{{ $jobListing->title }}</h1>
                            @auth
                                @if (auth()->user()->hasFavorited($jobListing))
                                    <form action="{{ route('favorites.destroy', $jobListing) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center space-x-1 text-red-500 hover:text-red-700">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                            </svg>
                                            <span>お気に入り解除</span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('favorites.store', $jobListing) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-1 text-gray-500 hover:text-red-500">
                                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                            </svg>
                                            <span>お気に入り登録</span>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <p class="text-gray-700 mt-1">{{ $jobListing->company_name }}</p>
                    </div>

                    <!-- 求人情報 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h2 class="text-lg font-semibold mb-2">基本情報</h2>
                            <table class="w-full border-collapse">
                                <tr class="border-b">
                                    <th class="py-2 text-left text-gray-600">職種</th>
                                    <td class="py-2">{{ $jobListing->jobType->name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 text-left text-gray-600">雇用形態</th>
                                    <td class="py-2">{{ $jobListing->employment_type }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 text-left text-gray-600">勤務地</th>
                                    <td class="py-2">{{ $jobListing->prefecture->name }} {{ $jobListing->location }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 text-left text-gray-600">給与</th>
                                    <td class="py-2">{{ $jobListing->salary_range }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 text-left text-gray-600">業界</th>
                                    <td class="py-2">{{ $jobListing->industry->name ?? '未設定' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="py-2 text-left text-gray-600">勤務条件</th>
                                    <td class="py-2">
                                        @if($jobListing->is_inexperienced_ok)
                                            <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs mr-2">未経験可</span>
                                        @endif
                                        @if($jobListing->is_remote_ok)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs">リモート可</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold mb-2">使用技術</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($jobListing->technologies as $technology)
                                    <span class="bg-gray-200 px-3 py-1 rounded">{{ $technology->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 職務内容 -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">職務内容</h2>
                        <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
                            {!! nl2br(e($jobListing->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
