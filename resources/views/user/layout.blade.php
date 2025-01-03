<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>LIBRAREAD</title>

    {{-- Development --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Production --}}
    <link rel="stylesheet" href="{{asset('build/assets/app-5NZ0x0VH.css')}}">
    <script type="module" src="{{asset('build/assets/app-DEdkgso6.js')}}" defer></script>

    {{-- FontAwosome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
        integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav
            class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
            <div class="max-w-screen-full flex flex-wrap items-center justify-between mx-auto py-4 px-10">
                <!-- Kiri -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="https://w7.pngwing.com/pngs/606/201/png-transparent-mississauga-library-system-school-library-public-library-online-public-access-catalog-library-miscellaneous-trademark-logo.png"
                        class="h-8" alt="Logo" />
                    <span
                        class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">LIBRAREAD</span>
                </a>

                <!-- Kanan -->
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <button id="dropdownDividerButton"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button" onclick="toggleDrawer()">
                        Hi, {{ explode(' ', Auth::user()->name)[0] }}
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                </div>
            </div>
        </nav>
        <!-- Dropdown menu -->
        <div id="dropdownDivider"
            class="fixed right-1 top-20 z-10 md:right-1 md:w-56 md:top-16 md:z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                <li>
                    <a href="{{ route('home') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Home</a>
                </li>
                <li>
                    <a href="{{ route('history') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">History</a>
                </li>
                <li>
                    <a href="{{ route('profile') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                </li>
            </ul>
            <div class="py-2">
                <a href="{{ route('logout') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Logout
                </a>
            </div>
        </div>
        <script>
            function toggleDrawer() {
                const drawer = document.getElementById('dropdownDivider');
                drawer.classList.toggle('hidden');
            }

            window.onclick = function(event) {
                const drawer = document.getElementById('dropdownDivider');
                const button = document.getElementById('dropdownDividerButton');
                if (!drawer.contains(event.target) && !button.contains(event.target)) {
                    drawer.classList.add('hidden');
                }
            }
        </script>

        <main class="px-8 mt-24">
            @yield('content')
        </main>
</body>

</html>
