@extends('layouts-admin.admin')

@section('title', 'ANGGOTA')

@section('content')
    <!-- HEADER BOX -->
    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center gap-4">
            <!-- BACK BUTTON -->
            <a href="{{ route('admin.members.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Edit Anggota</h1>
                <p class="text-sm text-slate-500">Perbarui informasi anggota yang sudah ada</p>
            </div>
        </div>
    </div>

    <!-- ALERT MESSAGE -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-green-500"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="text-green-500 hover:text-green-700">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- FORM CARD -->
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Error global --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- USERNAME FIELD -->
            <div class="mb-5">
                <label for="username" class="block text-sm font-medium text-slate-700 mb-2">
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text" name="username" id="username" value="{{ old('username', $member->username) }}" required
                    class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                           focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                           placeholder:text-stone-400"
                    placeholder="Masukkan username">
                @error('username')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NAME FIELD -->
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}" required
                    class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                           focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                           placeholder:text-stone-400"
                    placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- MEMBER NUMBER FIELD -->
            <div class="mb-5">
                <label for="number" class="block text-sm font-medium text-slate-700 mb-2">
                    Nomor Anggota <span class="text-red-500">*</span>
                </label>
                <input type="text" name="number" id="number" value="{{ old('number', $member->number) }}" required
                    class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                           focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                           placeholder:text-stone-400"
                    placeholder="Masukkan nomor anggota">
                @error('number')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- EMAIL FIELD -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}" required
                    class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                           focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                           placeholder:text-stone-400"
                    placeholder="Masukkan alamat email">
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <input type="hidden" name="role" value="user">

            <!-- BUTTON SUBMIT -->
            <div class="flex justify-end gap-3 pt-6 border-t border-stone-100">
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white
                       transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection