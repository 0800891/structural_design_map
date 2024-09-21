<x-app-layout>
    <x-slot name="header" style="background-color:rgb(236,230,198)">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <button onclick=location.href="{{ url('/') }}" 
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-4 mb-4 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Top Page
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    {{-- Display liked projects --}}
                    <h3 class="text-lg font-semibold mt-6 px-6">{{ __('Liked Projects') }}</h3>
                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 px-6 flex flex-wrop"> --}}
                    <div class="gap-4 mt-4 px-6 flex flex-wrop">
                        @foreach ($likedProjects as $project)
                        <div class="border mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex-grow">
                            {{-- <p class="text-gray-800 dark:text-gray-300">{{ $project->name }}</p> --}}
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">{{ $project->name }}</a>
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $project->company->name }}</p>
                            
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
    </div>
    
</x-app-layout>