<x-app-layout>
    <x-slot name="header" style="background-color:rgb(236,230,198)">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Guide') }}
        </h2>
    </x-slot>

    {{-- <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden text-lg font-bold shadow-sm sm:rounded-lg">
                <div class="px-6 py-3 text-gray-900">
                    {{ __("User Guide") }}
                    
                </div>
            </div>
        </div>
    </div> --}}


    {{-- Explanation of Structural Design Map --}}
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold my-6 px-6">{{ __('Structural Design Map') }}</h3>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            "test"
                        </div>
                    </div>
            </div>
        </div>
    </div>

    {{-- Explanation of Project List--}}
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold my-6 px-6">{{ __('Project List') }}</h3>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        "test"
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Explanation for Register New Project--}}
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold my-6 px-6">{{ __('Register New Project') }}</h3>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        "test"
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Explanation for Company List--}}
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold my-6 px-6">{{ __('Company List') }}</h3>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        "test"
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Explanation for Register New Company--}}
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-semibold my-6 px-6">{{ __('Register New Company') }}</h3>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        "test"
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>