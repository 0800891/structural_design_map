<!-- resources/views/tweets/show.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Project詳細') }}
    </h2>
  </x-slot>
  <header>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" defer type="text/javascript"></script>
  </header>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <div class="flex space-x-4">
              <a href="{{ route('projects.index') }}" class="text-blue-500 hover:text-blue-700 mr-2 text-sm">Back to Project Lists</a>
               /
              <a href="{{ route('maps.index', ['project_id' => $project->id]) }}" class="text-blue-500 hover:text-blue-700 mr-2 text-sm">Check in Structural Design Map</a>
          </div>
          <p class="text-gray-800 dark:text-gray-300 text-lg hidden">{{ $project->id }}</p>
          <p class="text-gray-600 dark:text-gray-400 text-lg">{{ $project->name }}</p>
          <p>Structural Designer: <a href="{{ route('companies.show', $company) }}" class="text-blue-500 hover:text-blue-700">{{$project->company->name}}</a></p>
          <p class="text-gray-600 dark:text-gray-400 text-sm">Address: {{ $project->address }}</p>
          <p class="text-gray-600 dark:text-gray-400 text-sm">Completion: {{ $project->completion }}</p>
          <p class="text-gray-800 dark:text-gray-400 text-lg">Design_Story: <br>{{ $project->design_story }}</p>
          
          <!-- Add Translation Form -->
          <div class="mt-4">
            <form method="POST" action="{{ route('translation') }}">
              @csrf
              <input type="hidden" name="sentence" value="{{ $project->design_story }}">
              
              <!-- Add Language Dropdown -->
              <label for="target_lang">Translate to:</label>
              <select name="target_lang" id="target_lang" class="border-gray-300 rounded-md shadow-sm">
                <option value="EN-US">English (US)</option>
                <option value="JA">Japanese</option>
                <option value="DE">German</option>
                <option value="FR">French</option>
                <option value="ES">Spanish</option>
                <option value="IT">Italian</option>
                <option value="ZH">Chinese (Simplified)</option>
              </select>
              
              <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Translate Design Story</button>
            </form>
          </div>
          
          <div class="mt-4">
            <h3>Project Images</h3>
            <div class="flex space-x-4">
                @if($project->picture_01_link)
                <a href="{{ asset($project->picture_01_link) }}" data-lightbox="group">
                    <img src="{{ asset($project->picture_01_link) }}" alt="Picture 01" class="w-32 h-32 object-cover">
                </a>
                @endif
                @if($project->picture_02_link)
                <a href="{{ asset($project->picture_02_link) }}" data-lightbox="group">
                    <img src="{{ asset($project->picture_02_link) }}" alt="Picture 02" class="w-32 h-32 object-cover">
                </a>
                @endif
                @if($project->picture_03_link)
                <a href="{{ asset($project->picture_03_link) }}" data-lightbox="group">
                    <img src="{{ asset($project->picture_03_link) }}" alt="Picture 03" class="w-32 h-32 object-cover">
                </a>
                @endif
            </div>
          </div>
          
          <div class="text-gray-600 dark:text-gray-400 text-sm">
            <p>作成日時: {{ $project->created_at->format('Y-m-d H:i') }}</p>
            <p>更新日時: {{ $project->updated_at->format('Y-m-d H:i') }}</p>
          </div>
        </form>
           <!--もしログインしている人のcompany idとprojectのidが一緒の場合-->
          @if (auth()->user()->company_id === $project->company_id)
          <div class="flex mt-4">
            <a href="{{ route('projects.edit', $project) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
            </form>
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
