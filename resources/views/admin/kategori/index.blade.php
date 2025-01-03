@extends('admin.layout')
@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Kategori</h1>

    {{-- Alert Message --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
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
    <form action="{{ route('admin.category.index') }}" method="GET" class="mb-4">
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
                placeholder="Cari data kategori..." required />
            <button type="submit"
                class="text-white absolute right-1.5 bottom-1.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1">Search</button>
        </div>
    </form>

    <div class="flex flex-row justify-between items-center mb-4">
        <a href="{{route('admin.category.index')}}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i
                class="fa-solid fa-arrows-rotate"></i>
        </a>
        <button onclick="toggleModal('addCategoryModal')"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex jus">Tambah Data</button>
    </div>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">No</th>
                    <th scope="col" class="px-6 py-3">Nama Kategori</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($categories->isEmpty())
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 text-center" colspan="3">No data available</td>
                </tr>
                @endif
                @foreach($categories as $category)
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $category->nama_kategori }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <button onclick='openEditModal({!! json_encode($category) !!})'
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Edit
                        </button>
                        <button onclick="openDeleteModal({{ $category->id }})"
                            class="font-medium text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $categories->links('pagination::tailwind') }}
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Kategori Baru</h3>
            </div>
            <form action="{{ route('admin.category.store') }}" method="POST">
                @csrf
                <div class="bg-white px-4 py-5 sm:p-6">
                    <div class="mb-4">
                        <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                            class="form-input mt-1 block w-full rounded border-gray-300">
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('addCategoryModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ubah Nama Kategori</h3>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 py-5 sm:p-6">
                    <div class="mb-4">
                        <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="edit_nama_kategori"
                            class="form-input mt-1 block w-full rounded border-gray-300">
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('editCategoryModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Category Modal -->
<div id="deleteCategoryModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Data Kategori</h3>
            </div>
            <form id="deleteCategoryForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="bg-white px-4 py-5 sm:p-6">
                    <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('deleteCategoryModal')">Cancel</button>
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

    function openEditModal(category) {
        console.log(category);
        document.getElementById('editCategoryForm').action = `/admin/category/${category.id}`;
        document.getElementById('edit_nama_kategori').value = category.nama_kategori;
        toggleModal('editCategoryModal');
    }

    function openDeleteModal(categoryId) {
        document.getElementById('deleteCategoryForm').action = `/admin/category/${categoryId}`;
        toggleModal('deleteCategoryModal');
    }
</script>

@endsection