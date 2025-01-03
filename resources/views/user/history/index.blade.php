@extends('user.layout')
@section('content')
    <div class="container mx-auto p-6">
        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Peminjaman Buku</h1>
        <div class="mb-4 ease-in-out duration-300">
            @if (session()->has('success'))
                <div id="alert-success"
                    class="flex justify-start w-full p-4 max-w-full mx-auto items-center text-base text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
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


        <!-- History Section -->
        <div class="space-y-6 break-all">
            <!-- Single Date Section -->
            @foreach ($history as $date => $datas)
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center sm:text-left">
                        {{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}
                    </h2>
                    <ul class="space-y-4">
                        @foreach ($datas as $data)
                            <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4">
                                <div class="mb-4 sm:mb-0">
                                    <h3 class="text-lg font-medium text-gray-800">{{ $data->buku->judul }}</h3>
                                    <p class="text-sm text-gray-500">Penulis: {{ $data->buku->pengarang }}</p>
                                </div>
                                <form action="{{ route('kembalikan-buku', $data->id) }}" method="POST"
                                    class="w-full sm:w-auto">
                                    @csrf
                                    @if ($data->returned === 1)
                                        <span
                                            class="block px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded text-center">
                                            Dikembalikan ({{ $data->tanggal_kembali->format('d/m/Y - H:i') }})
                                        </span>
                                    @else
                                        <button type="submit"
                                            class="w-full sm:w-auto px-4 py-2 bg-green-500 text-white text-sm font-medium rounded hover:bg-green-600 transition text-center">
                                            Kembalikan
                                        </button>
                                    @endif
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
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
.
