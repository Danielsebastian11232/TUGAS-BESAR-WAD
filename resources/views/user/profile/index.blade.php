@extends('user.layout')
@section('content')
{{-- Alert --}}
<div class=" ease-in-out duration-300">
    @if (session('success'))
    <div id="alert-success"
        class="flex justify-start w-full p-4 max-w-4xl mx-auto items-center text-base text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
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
    @elseif($errors->any())
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
            <span class="font-medium">Gagal!</span> {{ $errors->first() }}
        </div>
    </div>
    @endif
</div>

<div class="max-w-5xl mx-auto bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white shadow rounded-lg max-w-4xl w-full p-6 space-y-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Profil</h1>
            <p class="text-sm text-gray-500">Perbarui informasi pribadi Anda di sini</p>
        </div>

        <!-- Profile Picture Section -->
        <div class="flex flex-col sm:flex-row items-center space-y-5 gap-4 sm:space-y-0 sm:space-x-6">
            <img class="w-32 h-32 rounded-full border border-gray-300 object-cover"
                src="{{ auth()->user()->avatar ? asset('img/profile/' . auth()->user()->avatar) : 'https://via.placeholder.com/150' }}"
                alt="Profile Picture">
            <div class="">
                <h2 class="text-lg font-semibold text-gray-800">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            {{-- Upload Profile Picture --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload
                    Profile Picture</label>
                <input
                    class="block max-w-2xl text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" id="avatar" name="avatar" type="file">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Only PNG or JPG (MAX.
                    800x400px).</p>
            </div>
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" placeholder="{{ auth()->user()->name }}"
                    class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm text-gray-700">
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="{{ auth()->user()->email }}"
                    class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm text-gray-700">
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" placeholder="Masukkan kata sandi baru"
                    class="mt-1 w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm text-gray-700">
            </div>

            <!-- Save Button -->
            <div class="text-center">
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-3 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition">
                    Simpan Perubahan
                </button>
            </div>
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
