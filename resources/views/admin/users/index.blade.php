@extends('admin.layout')
@section('content')
<div class="container mx-auto">

    <h1 class="text-2xl font-bold mb-4">Daftar Pengguna</h1>

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
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
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
        <a href="{{route('admin.users.index')}}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i
                class="fa-solid fa-arrows-rotate"></i>
        </a>
        <button onclick="toggleModal('addUserModal')"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Tambah Data</button>
    </div>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-nowrap">No</th>
                    <th scope="col" class="px-6 py-3 text-center text-nowrap">Foto Profil</th>
                    <th scope="col" class="px-6 py-3 text-nowrap">Nama / Email</th>
                    <th scope="col" class="px-6 py-3 text-nowrap">No. Handphone</th>
                    <th scope="col" class="px-6 py-3 text-nowrap">Tanggal Lahir</th>
                    <th scope="col" class="px-6 py-3 text-nowrap text-center">Role</th>
                    <th scope="col" class="px-6 py-3 text-center text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($users->isEmpty())
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 text-center" colspan="7">No data available</td>
                </tr>
                @endif
                @foreach($users as $user)
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($user->avatar)
                        <img src="{{ asset('img/profile/'.$user->avatar) }}" alt="Foto Profil"
                            class="w-10 h-10 rounded-full mx-auto">
                        @else
                        <div class="flex justify-center items-center mx-auto w-10 h-10 rounded-full bg-gray-300"><i
                                class="fa-solid fa-user"></i></div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-nowrap">{{ $user->name }} / {{$user->email}}</td>
                    <td class="px-6 py-4 text-nowrap">{{ $user->phone_number }}</td>
                    <td class="px-6 py-4 text-nowrap">{{ $user->date_of_birth->format('j F Y') }}</td>
                    <td class="px-6 py-4 text-nowrap">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                    <td class="px-6 py-4 text-nowrap">
                        <div class="flex flex-wrap justify-center gap-4">
                            <button onclick='openEditModal({!! json_encode($user) !!})'
                                class="font-medium text-blue-600 hover:underline">
                                Edit
                            </button>
                            <button onclick="openDeleteModal({{ $user->id }})"
                                class="font-medium text-red-600 hover:underline">Delete</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Data User</h3>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-4 bg-white px-4 py-5 sm:p-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name"
                            class="form-input mt-1 block w-full rounded border-gray-300" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-input mt-1 block w-full rounded border-gray-300" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor
                                Handphone</label>
                            <input type="text" name="phone_number" id="phone_number"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal
                                Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role" class="form-select mt-1 block w-full rounded border-gray-300"
                            required>
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('addUserModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ubah Data User</h3>
            </div>
            <form id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-col gap-4 bg-white px-4 py-5 sm:p-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name"
                            class="form-input mt-1 block w-full rounded border-gray-300" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="edit_email"
                            class="form-input mt-1 block w-full rounded border-gray-300" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor
                                Handphone</label>
                            <input type="text" name="phone_number" id="edit_phone_number"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal
                                Lahir</label>
                            <input type="date" name="date_of_birth" id="edit_date_of_birth"
                                class="form-input mt-1 block w-full rounded border-gray-300" required>
                        </div>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="edit_role" class="form-select mt-1 block w-full rounded border-gray-300"
                            required>
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Ganti Password</label>
                            <input type="password" name="password" id="password"
                                class="form-input mt-1 block w-full rounded border-gray-300">
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-input mt-1 block w-full rounded border-gray-300">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('editUserModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div id="deleteUserModal" class="fixed z-10 inset-0 overflow-y-auto bg-black/40 hidden p-4">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Data User</h3>
            </div>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="bg-white px-4 py-5 sm:p-6">
                    <p>Apakah Anda yakin ingin menghapus user ini?</p>
                </div>
                <div class="bg-gray-100 px-4 py-3 border-t border-gray-200 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                        onclick="toggleModal('deleteUserModal')">Cancel</button>
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

    function openEditModal(user) {
        console.log(user);
        document.getElementById('editUserForm').action = `/admin/users/${user.id}`;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_phone_number').value = user.phone_number;
        document.getElementById('edit_date_of_birth').value = new Date(user.date_of_birth).toISOString().split('T')[0];
        document.getElementById('edit_role').value = user.is_admin ? 1 : 0;
        toggleModal('editUserModal');
    }
    function openDeleteModal(bookId) {
        document.getElementById('deleteUserForm').action = `/admin/koleksi-buku/${bookId}`;
        toggleModal('deleteUserModal');
    }
</script>

@endsection
