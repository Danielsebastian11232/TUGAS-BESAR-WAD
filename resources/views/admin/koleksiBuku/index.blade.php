@extends('admin.layout')
@section('content')
<div class="container mx-auto">

    <h1 class="text-2xl font-bold mb-4">Daftar Koleksi Buku</h1>

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

    {{-- Search Form --}}
    <form action="{{ route('admin.koleksi-buku.index') }}" method="GET" class="mb-4">
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" id="default-search" name="search" value="{{$search}}"
                class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                placeholder="Cari data buku..." required />
            <button type="submit"
                class="text-white absolute right-1.5 bottom-1.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1">Search</button>
        </div>
    </form>


    <div class="flex flex-row justify-between items-center mb-4">
        <a href="{{route('admin.koleksi-buku.index')}}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i
                class="fa-solid fa-arrows-rotate"></i>
        </a>
        <button onclick="toggleModal('addBookModal')"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Tambah Data</button>
    </div>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-nowrap">No</th>
                    <th scope="col" class="px-6 py-3 text-center text-nowrap">Kode Buku</th>
                    <th scope="col" class="px-6 py-3 text-nowrap">Judul</th>
                    <th scope="col" class="px-6 py-3 text-nowrap">Pengarang / Penerbit</th>
                    <th scope="col" class="px-6 py-3 text-nowrap">Tahun Diterbitkan</th>
                    <th scope="col" class="px-6 py-3 text-center text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($books->isEmpty())
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 text-center" colspan="6">No data available</td>
                </tr>
                @endif
                @foreach($books as $book)
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-center">{{ $book->kode_buku }}</td>
                    <td class="px-6 py-4 text-nowrap">{{ $book->judul }}</td>
                    <td class="px-6 py-4">{{ $book->pengarang }} / {{$book->penerbit}}</td>
                    <td class="px-6 py-4">{{ $book->tahun_terbit->format('j F Y') }}</td>
                    <td class="px-6 py-4 flex flex-wrap justify-center gap-4">
                        <a href="{{ route('admin.koleksi-buku.show', $book->id) }}"
                            class="font-medium text-yellow-600 hover:underline">
                            Detail
                        </a>
                        <button onclick='openEditModal({!! json_encode($book) !!})'
                            class="font-medium text-blue-600  hover:underline">
                            Edit
                        </button>
                        <button onclick="openDeleteModal({{ $book->id }})"
                            class="font-medium text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $books->links('pagination::tailwind') }}
    </div>
</div>

<!-- Add Book Modal -->
<div id="addBookModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Data Buku</h3>
            </div>
            <form action="{{ route('admin.koleksi-buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-4 bg-white px-4 py-5 sm:p-6">
                    <div>
                        <label for="cover" class="block text-sm font-medium text-gray-700">Cover Buku</label>
                        <input type="file" name="cover" id="cover" accept=".jpeg, .png, .jpg"
                            class="form-input mt-1 block w-full rounded border-gray-300 border" required>
                        <span class="text-xs italic text-red-500">Hanya terima tipe gambar .jpeg, .jpg, .png</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kode_buku" class="block text-sm font-medium text-gray-700">Kode Buku</label>
                            <input type="text" name="kode_buku" id="kode_buku"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        {{-- select from $categories --}}
                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori_id" id="kategori_id"
                                class="form-select mt-1 block w-full rounded border-gray-300" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" id="judul"
                            class="form-input mt-1 block w-full rounded border-gray-300" required>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pengarang" class="block text-sm font-medium text-gray-700">Pengarang</label>
                            <input type="text" name="pengarang" id="pengarang"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        <div>
                            <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
                            <input type="text" name="penerbit" id="penerbit"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun
                                Terbit</label>
                            <input type="date" name="tahun_terbit" id="tahun_terbit"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        <div>
                            <label for="stok_buku" class="block text-sm font-medium text-gray-700">Stok Buku</label>
                            <input type="number" name="stok_buku" id="stok_buku"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi"
                            class="form-textarea mt-1 block w-full rounded border-gray-300" required></textarea>
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('addBookModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Book Modal -->
<div id="editBookModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ubah Data Buku</h3>
            </div>
            <form id="editBookForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4 bg-white px-4 py-5 sm:p-6">
                    <div class="flex flex-col">
                        <img id="edit_cover_buku" alt="" class="w-full max-w-xs rounded-lg mb-4 mx-auto">
                        <label for="cover" class="block text-sm font-medium text-gray-700">Ganti Cover Buku</label>
                        <input type="file" name="cover" id="cover" accept=".jpeg, .png, .jpg"
                            class="form-input mt-1 block w-full rounded border-gray-300 border">
                        <span class="text-xs italic text-red-500">Hanya terima tipe gambar .jpeg, .jpg, .png</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="kode_buku" class="block text-sm font-medium text-gray-700">Kode Buku</label>
                            <input type="text" name="kode_buku" id="edit_kode_buku"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        {{-- select from $categories --}}
                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="kategori_id" id="edit_kategori_id"
                                class="form-select mt-1 block w-full rounded border-gray-300" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" id="edit_judul"
                            class="form-input mt-1 block w-full rounded border-gray-300" required>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pengarang" class="block text-sm font-medium text-gray-700">Pengarang</label>
                            <input type="text" name="pengarang" id="edit_pengarang"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        <div>
                            <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
                            <input type="text" name="penerbit" id="edit_penerbit"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun
                                Terbit</label>
                            <input type="date" name="tahun_terbit" id="edit_tahun_terbit"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        <div>
                            <label for="stok_buku" class="block text-sm font-medium text-gray-700">Stok Buku</label>
                            <input type="number" name="stok_buku" id="edit_stok_buku"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi"
                            class="form-textarea mt-1 block w-full rounded border-gray-300" required></textarea>
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('editBookModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Book Modal -->
<div id="deleteBookModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Data Buku</h3>
            </div>
            <form id="deleteBookForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="bg-white px-4 py-5 sm:p-6">
                    <p>Apakah Anda yakin ingin menghapus buku ini?</p>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('deleteBookModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }

    function openEditModal(book) {
        console.log(book);
        document.getElementById('editBookForm').action = `/admin/koleksi-buku/${book.id}`;
        document.getElementById('edit_cover_buku').src = `{{ asset('img/books/cover/') }}/${book.cover}`;
        document.getElementById('edit_kode_buku').value = book.kode_buku;
        document.getElementById('edit_kategori_id').value = book.kategori ? book.kategori.id : '';
        document.getElementById('edit_judul').value = book.judul;
        document.getElementById('edit_pengarang').value = book.pengarang;
        document.getElementById('edit_penerbit').value = book.penerbit;
        document.getElementById('edit_tahun_terbit').value = new Date(book.tahun_terbit).toISOString().split('T')[0];
        document.getElementById('edit_stok_buku').value = book.stok_buku;
        document.getElementById('edit_deskripsi').value = book.deskripsi;
        toggleModal('editBookModal');
    }
    function openDeleteModal(bookId) {
        document.getElementById('deleteBookForm').action = `/admin/koleksi-buku/${bookId}`;
        toggleModal('deleteBookModal');
    }
</script>

@endsection