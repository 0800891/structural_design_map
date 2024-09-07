<x-app-layout>
    <x-slot name="header" style="background-color:rgb(236,230,198)">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" >
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <button onclick=location.href="{{ url('/') }}" 
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-4 mb-4 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                    >
                    Top Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
