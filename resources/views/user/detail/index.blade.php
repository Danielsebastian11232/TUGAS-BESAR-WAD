@extends('user.layout')
@section('content')
    <div class="mb-4">
        @if (session()->has('success'))
            <div id="alert-success"
                class="flex justify-start w-full p-4 max-w-5xl mx-auto items-center text-base text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Berhasil!</span> {{ session('success') }}
                </div>
            </div>
        @elseif(session()->has('error'))
            <div id="alert-error"
                class="flex justify-start w-full p-4 max-w-5xl mx-auto items-center text-base text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Gagal!</span> {{ session('error') }}
                </div>
            </div>
        @endif
    </div>
    <div class="w-full max-w-5xl grid grid-cols-1 sm:grid-cols-[1fr,2fr] gap-4 bg-white rounded-lg p-6 mx-auto">
        <div class="w-full">
            <img src="{{ asset('img/books/cover/' . $book->cover) }}" alt=""
                class="w-full object-cover object-center rounded-lg">
        </div>
        <div class="flex flex-col space-y-3 break-all">
            <h1 class="text-2xl font-bold">{{ $book->judul }}</h1>
            <h1 class="text-base text-gray-400 italic">{{ $book->kode_buku }}</h1>
            <h1 class="text-xl">Pengarang: <span class="font-semibold">{{ $book->pengarang }}</span></h1>
            <h1 class="text-xl">Penerbit: <span class="font-semibold">{{ $book->penerbit }} -
                    {{ $book->tahun_terbit->format('d/m/Y') }}</span></h1>
            <p
                class="@if ($book->stok_buku <= 5) text-red-500 bg-red-300 @else text-blue-500 bg-blue-300 @endif rounded-md px-3 py-1 w-fit font-semibold">
                Stok:{{ $book->stok_buku }}
            </p>
            <h1 class="text-xl font-semibold">Deskripsi: </h1>
            <p> {{ $book->deskripsi }} </p>

            <form action="{{ route('pinjam-buku', $book->id) }}" method="POST">
                @csrf
                <button
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition-all mt-4">
                    Pinjam Buku
                </button>
            </form>
        </div>
    </div>
    {{-- SCRIPT JS --}}
    <script>
        setTimeout(() => {
            const successAlert = document.getElementById('alert-success');
            const errorAlert = document.getElementById('alert-error');

            if (successAlert) {
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }

            if (errorAlert) {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 3000);
    </script>
@endsection
