<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Company詳細') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <a href="{{ route('companies.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
            <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $company->id }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Company Name: {{ $company->name }}</p>
            <div class="text-gray-600 dark:text-gray-400 text-sm">
              <p>作成日時: {{ $company->created_at->format('Y-m-d H:i') }}</p>
              <p>更新日時: {{ $company->updated_at->format('Y-m-d H:i') }}</p>
            </div>
             <!--もしログインしている人のidとtweetした人のidが一緒の場合-->
            @if (auth()->user()->company_id === $company->id)
            <div class="flex mt-4">
              <a href="{{ route('companies.edit', $company) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
              {{-- <form action="{{ route('companies.destroy', $company) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
              </form> --}}
            </div>
            @endif
            {{-- <div class="mt-4">
              <p class="text-gray-600 dark:text-gray-400 ml-4">comment {{ $tweet->comments->count() }}</p>
              <a href="{{ route('tweets.comments.create', $tweet) }}" class="text-blue-500 hover:text-blue-700 mr-2">コメントする</a>
            </div>
            <div class="mt-4">
              @foreach ($tweet->comments as $comment)
              <a href="{{ route('tweets.comments.show', [$tweet, $comment]) }}">
              <p>{{ $comment->comment }} <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $comment->user->name }} {{ $comment->created_at->format('Y-m-d H:i') }}</span></p>
              @endforeach
            </div> --}}
  
          </div>
        </div>
      </div>
    </div>
  </x-app-layout>
  