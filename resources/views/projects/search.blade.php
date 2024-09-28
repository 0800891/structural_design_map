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

                            <!-- Feedback Section -->
                            <div class="mt-4">
                                <form action="{{ route('projects.feedback', $project->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="search_query" value="{{ request('search_query') }}"> <!-- Store search query -->
                                    
                                    <label for="feedback_comment_{{ $project->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Your Feedback:</label>
                                    <textarea id="feedback_comment_{{ $project->id }}" name="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Leave a comment..."></textarea>
                                    
                                    <div class="flex space-x-4 mt-2">
                                        <button type="submit" name="feedback" value="good" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-700">Good</button>
                                        <button type="submit" name="feedback" value="bad" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-700">Bad</button>
                                    </div>
                                </form>
                            </div>

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
