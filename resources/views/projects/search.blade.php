<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-wrap">
                    <!-- Display Search Results -->
                    @if($projects->isEmpty())
                        <p class="text-red-500">No projects found based on your search.</p>
                    @else
                        @foreach ($projects as $project)
                        <div class="border mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex-grow">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-300">{{ $project->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">
                                    View {{ $project->name }}
                                </a>
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $project->company->name }}</p>

                            <!-- Display project image if available -->
                            @if($project->picture_01_link)
                                <img src="{{ asset($project->picture_01_link) }}" alt="{{ $project->name }} Image" class="w-32 h-32 object-cover mt-2">
                            @endif

                            <!-- Like/Dislike Button -->
                            <div class="flex mt-2">
                                @if ($project->liked->contains(auth()->id()))
                                <form action="{{ route('projects.dislike', $project) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Dislike ({{ $project->liked->count() }})</button>
                                </form>
                                @else
                                <form action="{{ route('projects.like', $project) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">Like ({{ $project->liked->count() }})</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>