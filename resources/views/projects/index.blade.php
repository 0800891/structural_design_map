<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Project一覧') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-wrap">
            @foreach ($projects as $project)
            <div class="bordermb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex-grow">
              <p class="text-gray-800 dark:text-gray-300">{{ $project->project }}</p>
              <p class="text-gray-600 dark:text-gray-400 text-sm"> 
                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">{{$project->name}} </a>/ Structural Designer: {{ $project->company->name }}
              </p>
                @if($project->picture_01_link)
                  {{-- <a href="{{ asset($project->picture_01_link) }}" data-lightbox="group"> --}}
                    <img src="{{ asset($project->picture_01_link) }}" alt="Picture 01" class="w-32 h-32 object-cover">
                {{-- </a> --}}
                @endif
                
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

  
  </x-app-layout>
  
  
  