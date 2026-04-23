@extends('layouts-admin.admin')

@section('title', 'ANGGOTA')

@section('content')
    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.members.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Tambah Anggota</h1>
                <p class="text-sm text-slate-500">Tambah anggota baru</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="bg-white rounded-xl shadow p-6 flex-1">
            <form id="memberForm" action="{{ route('admin.members.store') }}" method="POST" autocomplete="off">
                @csrf

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

                <div class="grid gap-4">
                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            autocomplete="off"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                              focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                              placeholder:text-slate-400"
                            placeholder="Masukkan username">
                        @error('username')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            autocomplete="off"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                              focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                              placeholder:text-slate-400"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Anggota --}}
                    <div>
                        <label for="number" class="block text-sm font-medium text-slate-700 mb-1">
                            Nomor Anggota <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="number" id="number" value="{{ old('number') }}" required
                            autocomplete="off"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                              focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                              placeholder:text-slate-400"
                            placeholder="Contoh: MEM-2024001">
                        @error('number')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            autocomplete="off"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                              focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                              placeholder:text-slate-400"
                            placeholder="contoh@email.com">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role (Hidden) --}}
                    <input type="hidden" name="role" value="user">
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 mt-6">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white
                           transition flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="hidden lg:flex w-full lg:w-1/3 xl:w-1/4 flex-col items-center justify-center">
            <div class="bg-white rounded-xl shadow p-8 w-full h-full flex flex-col items-center justify-center">
                <div class="mb-6">
                    <div
                        class="w-48 h-48 mx-auto bg-gradient-to-br from-sky-100 to-sky-50 
                        rounded-full flex items-center justify-center shadow-inner border border-sky-100">
                        <i class="fa-solid fa-user-plus text-6xl text-sky-500"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Tambah Anggota Baru</h3>
                    <p class="text-sm text-slate-500">Isi semua field dengan benar.</p>
                    <p class="text-xs text-slate-400 mt-3">Password akan digenerate otomatis</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const form = document.getElementById('memberForm');

        // Validasi sebelum submit
        form.addEventListener('submit', function(e) {
            let isValid = true;

            // Reset error styles
            document.querySelectorAll('input').forEach(input => {
                input.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
            });

            // Check all required fields
            const requiredFields = ['username', 'name', 'number', 'email'];
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Semua field harus diisi!',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Tampilkan SweetAlert sukses jika ada session success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: '{{ session('success') }}',
                confirmButtonColor: '#0ea5e9',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirect otomatis setelah klik OK
                window.location.href = '{{ route("admin.members.index") }}';
            });
        @endif

        // Tampilkan SweetAlert error jika ada session error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush