@extends('admin.layout')
@section('content')
<div class="container mx-auto">
    {{-- back button --}}
    <div class="mb-4">
        <a href="{{ route('admin.koleksi-buku.index') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i
                class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="flex flex-col gap-4">
        <h1 class="text-2xl font-bold mb-4">Buku {{$book->judul}}</h1>

        {{-- Cover --}}
        <div class="flex flex-col gap-4">
            <div class="w-48">
                <img src="{{ asset('img/books/cover/'.$book->cover) }}" alt="{{ $book->judul }}" class="w-full h-auto">
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex flex-col gap-2">
                    <div class="flex flex-row gap-2">
                        <div class="font-bold">Pengarang</div>
                        <div>{{$book->pengarang}}</div>
                    </div>
                    <div class="flex flex-row gap-2">
                        <div class="font-bold">Penerbit</div>
                        <div>{{$book->penerbit}}</div>
                    </div>
                    <div class="flex flex-row gap-2">
                        <div class="font-bold">Tahun Terbit</div>
                        <div>{{$book->tahun_terbit->format('j F Y')}}</div>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex flex-row gap-2">
                        <div class="font-bold">Kategori</div>
                        <div>{{$book->kategori->nama_kategori}}</div>
                    </div>
                    <div class="flex flex-row gap-2">
                        <div class="font-bold">Stok Buku</div>
                        <div>{{$book->stok_buku}}</div>
                    </div>
                    <div class="flex flex-row gap-2">
                        <div class="font-bold">Deskripsi</div>
                        <div>{{$book->deskripsi}}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Message --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error') || $errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            @foreach ($errors->all() as $error)
            <span class="block sm:inline">{{ $error }}</span>
            @endforeach
            @if(session('error'))
            <span class="block sm:inline">{{ session('error') }}</span>
            @endif
        </div>
        @endif


        <div class="flex flex-row gap-4 items-center mb-4">
            <a href="{{ route('admin.koleksi-buku.show', $book->id) }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i
                    class="fa-solid fa-arrows-rotate"></i>
            </a>
            {{-- Select Filterisasi data pinjam sudah dikembalikan atau belum --}}
            <form action="{{ route('admin.koleksi-buku.show', $book->id) }}" method="GET" class="flex">
                <select name="returned" id="returned"
                    class="block py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="1" {{ $returned==1 ? 'selected' : '' }}>Sudah Dikembalikan</option>
                    <option value="0" {{ $returned==0 ? 'selected' : '' }}>Belum Dikembalikan</option>
                </select>
            </form>
        </div>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center text-nowrap">No</th>
                        <th scope="col" class="px-6 py-3 text-center text-nowrap">Nama Peminjam</th>
                        <th scope="col" class="px-6 py-3 text-nowrap">Tanggal Meminjam</th>
                        <th scope="col" class="px-6 py-3 text-nowrap">Tanggal Dikembalikan</th>
                    </tr>
                </thead>
                <tbody>
                    @if($listOfBorrowers->isEmpty())
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-4 text-center" colspan="4">No data available</td>
                    </tr>
                    @endif
                    @foreach($listOfBorrowers as $borrower)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-center">{{ $borrower->user->name }}</td>
                        <td class="px-6 py-4 text-nowrap">{{ $borrower->tanggal_pinjam }}</td>
                        <td class="px-6 py-4 text-nowrap">{{ $borrower->returned==1 ? $borrower->tanggal_kembali :
                            'Belum
                            dikembalikan' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $listOfBorrowers->links('pagination::tailwind') }}
        </div>
    </div>

    @endsection