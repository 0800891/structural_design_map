<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Company Detail') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <a href="{{ route('companies.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">Back to Companies List</a>
            {{-- <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $company->id }}</p> --}}
            <p class="text-gray-600 dark:text-gray-400 text-lg">Name: {{ $company->name }}</p>
           
            <div class="py-12">
              <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- <table border="1"> --}}
                    {{-- <tr> --}}
                  <p>Employee List</p>
                  <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-wrap">
                  @foreach($users as $user)
                    @if($company->id === $user->company_id)
                    {{-- <th> --}}
                    <div class="border mb-4 p-2 bg-gray-100 dark:bg-gray-700 rounded-lg flex-grow">
                      {{-- <p class="text-gray-800 dark:text-gray-300">{{ $project->name }}</p> --}}
                      <p class="text-gray-600 dark:text-gray-400 text-sm">{{$user->name}} </p>
                    </div>
                
                    @endif
                  @endforeach
                  </div>
                    {{-- </tr> --}}
                  {{-- </table> --}}
                    {{-- <table border="1"> --}}
                    {{-- <tr> --}}
                  <p>Project List</p>
                  <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-wrap">
                  @foreach($projects as $project)
                    @if($company->id === $project->company_id)
                    {{-- <th> --}}
                      <div class="border mb-2 p-2 bg-gray-100 dark:bg-gray-700 rounded-lg  flex-grow">
                         {{-- <p class="text-gray-800 dark:text-gray-300">{{ $project->name }}</p> --}}
                         <p class="text-gray-600 dark:text-gray-400 text-sm"><a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">{{$project->name}} </a></p>
                         @if($project->picture_01_link)
                         {{-- <a href="{{ asset($project->picture_01_link) }}" data-lightbox="group"> --}}
                           <img src="{{ asset($project->picture_01_link) }}" alt="Picture 01" class="w-32 h-32 object-cover">
                       {{-- </a> --}}
                         @endif
                      </div>
                    {{-- </th> --}}
                    @endif
                  @endforeach
                  </tr>
                {{-- </table> --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="text-gray-600 dark:text-gray-400 text-sm">
              <p>Created At: {{ $company->created_at->format('Y-m-d H:i') }}</p>
              <p>Updated At: {{ $company->updated_at->format('Y-m-d H:i') }}</p>
            </div>
             <!--もしログインしている人のidとtweetした人のidが一緒の場合-->
            @if (auth()->user()->company_id === $company->id)
            <div class="flex mt-4">
              <a href="{{ route('companies.edit', $company) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit Company Info</a>
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
  