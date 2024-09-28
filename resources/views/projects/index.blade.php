<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Project List') }}
      </h2>
    </x-slot>

        <!-- Search Form -->
        <div class="py-2 max-w-7xl  mx-auto sm:px-6 lg:px-8">
          <form action="{{ route('projects.openai_search') }}" method="GET">
            @csrf
            <div class="flex">
                <input type="text" name="search_query" class="form-input rounded-lg shadow-sm w-full" placeholder="Search for projects with Chat gpt-4o-mini...">
                <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">Search</button>
            </div>
        </form>
      </div>

      <div class="py-2 max-w-7xl  mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('projects.index') }}" method="GET">
            @csrf
            <div class="flex">
            <select id="select_company" name="company_id" class="form-input rounded-lg shadow-sm w-full">
                <option value="1" {{ request('company_id') == 1 ? 'selected' : '' }}>ALL Companies</option>
                @foreach($companies as $company)
                @if($company->id>1)
                    <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endif
                @endforeach
            </select>
            <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">Select</button>
          </div>
          </form>
    </div>
  
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-wrap">
            {{-- @if() --}}
            @foreach ($projects as $project)
            <div class="border mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex-grow">
              <p class="text-gray-800 dark:text-gray-300">{{ $project->project }}</p>
              <p class="text-gray-600 dark:text-gray-400 text-sm"> 
                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">{{$project->name}} </a>
              </p>
              <p class="text-gray-600 dark:text-gray-400 text-sm">/ {{ $project->company->name }}</p>
                @if($project->picture_01_link)
                  {{-- <a href="{{ asset($project->picture_01_link) }}" data-lightbox="group"> --}}
                    <img src="{{ asset($project->picture_01_link) }}" alt="Picture 01" class="w-32 h-32 object-cover">
                {{-- </a> --}}
                @endif
            <div class="flex">
              @if ($project->liked->contains(auth()->id()))
              <form action="{{ route('projects.dislike', $project) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">dislike {{$project->liked->count()}}</button>
              </form>
              @else
              <form action="{{ route('projects.like', $project) }}" method="POST">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700">like {{$project->liked->count()}}</button>
              </form>
              @endif
            </div>
            </div>
            @endforeach
            {{-- @else
            @endif --}}
          </div>
        </div>
      </div>
    </div>

  
  </x-app-layout>
  
  
  