<!-- resources/views/translation.blade.php -->
<x-app-layout>
    <x-slot name="header" style="background-color:rgb(236,230,198)">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Translation Result') }}
        </h2>
    </x-slot>
<html>
<head>
    <meta charset='utf-8' />
     <!-- Favicon -->
     <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
</head>
<body>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <p hidden><strong>Original Text:</strong></p>
    <p hidden>{{ $sentence }}</p>

    <p class="p-4 text-gray-600 dark:text-gray-400 "><strong>Translated to {{ $target_lang }}:</strong></p>
    <p class="p-4 text-gray-600 dark:text-gray-400 ">{{ $translated_text }}</p>

    <a href="{{ url()->previous() }}" class="text-blue-500 p-4">Go Back</a>
          </div>
        </div>
    </div>

</body>
</html>

</x-app-layout>