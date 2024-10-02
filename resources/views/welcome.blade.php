<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.tailwindcss.com"></script>

        <title>Structural Design Map</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
        
    </head>
    <body class= "font-sans antialiased dark:bg-black dark:text-white/50" style="background-color:rgb(236,230,198)">
        
        <div class=" text-black/50 dark:bg-black dark:text-white/50" style="background-color:rgb(236,230,198)">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex items-center">
                          <img src="/storage/img/logo_01.png" class="w-1/5" alt="logo">
                          <p class="text-3xl ml-4  dark:text-gray-400">Structural Design Map</p>
                        </div>
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-gray-400 dark:hover:text-gray-800 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-3 lg:grid-cols-2 lg:gap-3">
                            <a
                                id="docs-card"
                                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                 <div>   
                                    <img src="/storage/img/Imaginary_Building_and_Bridge_On_worldmap_02.webp" class="bg-center bg-cover">
                                    <div
                                        class="absolute -bottom-16 -left-16 h-40 w-[calc(100%+8rem)] bg-gradient-to-b from-transparent via-white to-white dark:via-zinc-900 dark:to-zinc-900"
                                    ></div>
                                </div>
                                
                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                        <div class="pt-3 sm:pt-5 lg:pt-0">
                                            <p class="mt-2 text-xl/relaxed">
                                                In Structural Design Map<br> you can find inspiring structural desing stories and register projects with your innovative strucural design.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                               
                                <div class="pt-3 sm:pt-3">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">
                                        Find Projects on World Map
                                    </h2>

                                    <p class="mt-2 text-sm/relaxed">
                                       Projects registered by structural engineering companies are visualized on the world map. You can check from the map where any projects you want to know are.
                                    </p>
                                </div>
                            </a>

                            <a
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >

                                <div class="pt-3 sm:pt-3">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">
                                         Find Structural Design Stories Globally
                                    </h2>

                                    <p class="mt-2 text-sm/relaxed">
                                        Project stories are registered and summurized with three pinup images by structural engineering companies all over the world. You can get innovative ideas of structural design.
                                        Stories are not written in English? Don't worry. You can translate stories into seven languages including English.
                                    </p>
                                </div>
                             </a>

                            <div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                                
                                <div class="pt-3 sm:pt-3">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">
                                         Bookmark Projetcs You liked
                                    </h2>

                                    <p class="mt-2 text-sm/relaxed">
                                        If you find your favorite projects, do not miss pressing "like" button shown in the bottom-most. By doing so, only your liked projects are shown in "Dashboard".
                                    </p>
                                </div>
                            </div>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-gray-500">
                        <small>&copy; 2024 aurinko LLC</small>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
