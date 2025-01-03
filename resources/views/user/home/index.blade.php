@extends('user.layout')
@section('content')
    <form class="max-w-lg mx-auto md:block">
        <div class="flex">
            <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your
                Email</label>
            <button id="dropdownCategory-button" data-dropdown-toggle="dropdown"
                class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                type="button">
                <i class="fa-solid fa-filter"></i>
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <form action="{{ route('home') }}" method="GET">
                <div class="relative w-full flex-grow">
                    <input type="search" id="search-dropdown" name="search"
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                        placeholder="Cari judul buku disini..." />
                    <button type="submit"
                        class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </form>
        </div>
    </form>

    <!-- Dropdown category -->
    <div id="dropdownCategory"
        class="absolute z-10 top-30 left-7 md:right-1/2 md:left-auto hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-64 dark:bg-gray-700">
        <form action="{{ route('home') }}" method="GET">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                <li>
                    <button type="submit" name="category" value="0"
                        class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Semua</button>
                </li>
                @foreach ($categories as $category)
                    <li>
                        <button type="submit" name="category" value="{{ $category->id }}"
                            class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $category->nama_kategori }}</button>
                    </li>
                @endforeach
            </ul>
        </form>
    </div>
    @if ($books->isEmpty())
        <div class="flex justify-center items-center h-screen ">
            <h1 class="mb-2 text-xl truncate font-semibold overflow-hidden text-gray-900 dark:text-white">
                Buku tidak ditemukan</h1>
        </div>
    @endif
    <div
        class="md:mt-3 p-3 flex justify-center items-center flex-col gap-4 md:grid md:grid-cols-4 md:gap-4 md:justify-center md:justify-items-center">
        @foreach ($books as $book)
            <div
                class="w-80 h-[400px] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col">
                <a href="/detail/{{ $book->id }}">
                    <img class="rounded-t-lg max-h-60 w-full object-cover object-center"
                        src="{{ asset('img/books/cover/' . $book->cover) }}" alt="{{ $book->judul }}" />
                </a>
                <div class="p-5 flex flex-col flex-grow">
                    <a href="#">
                        <h1 class="mb-2 text-xl truncate font-semibold overflow-hidden text-gray-900 dark:text-white">
                            {{ $book->judul }}</h1>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 break-words whitespace-normal flex-grow">
                        Oleh: {{ $book->pengarang }}
                    </p>
                    <a href="{{ route('detail', $book->id) }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-auto">
                        Lihat Buku
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>


    <script>
        document.getElementById('dropdownCategory-button').addEventListener('click', function() {
            var dropdown = document.getElementById('dropdownCategory');
            dropdown.classList.toggle('hidden');
        });
    </script>
@endsection
