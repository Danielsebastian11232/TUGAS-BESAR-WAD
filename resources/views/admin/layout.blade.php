<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Dashboard Admin</title>

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
        {{-- Header --}}
        <header class="bg-white shadow">
            <div class="flex justify-between items-center px-4 py-6">
                <h1 class="text-2xl font-bold">Admin Dashboard Perpustakaan</h1>
                <div class="flex flex-row space-x-2 items-center">
                    <a href="{{route('logout')}}"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><i
                            class="fa-solid fa-sign-out"></i>
                    </a>
                </div>
            </div>
            {{-- menu list --}}
            <nav class="bg-gray-800 text-white ">
                <ul
                    class="flex flex-row text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 container mx-auto overflow-x-auto text-nowrap">
                    <li class="me-2">
                        <a href="{{route('admin.category.index')}}"
                            class="inline-block p-4 hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 {{ request()->routeIs('admin.category.index') ? 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500' : '' }}">Kategori</a>
                    </li>
                    <li class="me-2">
                        <a href="{{route('admin.koleksi-buku.index')}}"
                            class="inline-block p-4 hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 {{ request()->routeIs('admin.koleksi-buku.*') ? 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500' : '' }}">Koleksi
                            Buku</a>
                    </li>
                    <li class="me-2">
                        <a href="{{route('admin.users.index')}}"
                            class="inline-block p-4 hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300 {{ request()->routeIs('admin.users.index') ? 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500' : '' }}">Users</a>
                    </li>
                </ul>
            </nav>
        </header>

        {{-- Content --}}
        <main class="flex-grow container mx-auto px-4 py-6">
            @yield('content')
        </main>

        {{-- Footer kalo perlu --}}
        {{-- <footer class="bg-white shadow">
            <div class="container mx-auto px-4 py-6">
                <p class="text-gray-700">&copy; 2023 Your Company. All rights reserved.</p>
            </div>
        </footer> --}}
    </div>
</body>

</html>
