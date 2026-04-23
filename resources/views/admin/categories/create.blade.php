@extends('layouts-admin.admin')

@section('title', 'KATEGORI')

@section('content')
    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categories.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Tambah Kategori</h1>
                <p class="text-sm text-slate-500">Tambah satu atau banyak kategori baru sekaligus</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="bg-white rounded-xl shadow p-6 flex-1">
            <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST">
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

                <div id="kategori-list" class="grid gap-3">
                    {{-- Row pertama (tidak bisa dihapus) --}}
                    <div class="kategori-row flex items-center gap-2">
                        <div class="flex-1">
                            <input type="text" name="category_names[]" value="{{ old('category_names.0') }}" required
                                class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                                  focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                                  placeholder:text-slate-400"
                                placeholder="Nama kategori #1">
                            @error('category_names.0')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="button" disabled
                            class="w-10 h-10 flex items-center justify-center rounded-lg
                               bg-slate-100 text-slate-300 cursor-not-allowed shrink-0">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

                {{-- Tombol Tambah Baris --}}
                <button type="button" id="btn-add-row"
                    class="mt-4 w-full py-2.5 rounded-lg border-2 border-dashed border-sky-200
                       text-sky-600 hover:bg-sky-50 hover:border-sky-300
                       transition flex items-center justify-center gap-2 text-sm font-medium">
                    <i class="fa-solid fa-plus"></i> Tambah Baris Kategori
                </button>

                {{-- Info jumlah --}}
                <p class="text-xs text-slate-400 mt-2 text-center">
                    <span id="row-count" class="font-medium text-sky-600">1</span> kategori akan dibuat
                </p>

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
                        <i class="fa-solid fa-tags text-6xl text-sky-500"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Buat Kategori Baru</h3>
                    <p class="text-sm text-slate-500">Pastikan nama kategori unik dan deskriptif.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const list = document.getElementById('kategori-list');
        const btnAdd = document.getElementById('btn-add-row');
        const counter = document.getElementById('row-count');
        const form = document.getElementById('categoryForm');

        function updateCounter() {
            const count = list.querySelectorAll('.kategori-row').length;
            counter.textContent = count;
        }

        function createRow(index) {
            const div = document.createElement('div');
            div.className = 'kategori-row flex items-center gap-2';
            div.innerHTML = `
                <div class="flex-1">
                    <input type="text"
                           name="category_names[]"
                           required
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                                  focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                                  placeholder:text-slate-400"
                           placeholder="Nama kategori #${index}">
                </div>
                <button type="button"
                        class="btn-remove w-10 h-10 flex items-center justify-center rounded-lg
                               bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600
                               transition shrink-0">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            div.querySelector('.btn-remove').addEventListener('click', () => {
                div.remove();
                updateCounter();
            });
            return div;
        }

        btnAdd.addEventListener('click', () => {
            const index = list.querySelectorAll('.kategori-row').length + 1;
            list.appendChild(createRow(index));
            updateCounter();
        });

        // Validasi sebelum submit
        form.addEventListener('submit', function(e) {
            const inputs = document.querySelectorAll('input[name="category_names[]"]');
            let isValid = true;

            inputs.forEach(input => {
                const value = input.value.trim();
                if (value === '') {
                    isValid = false;
                    input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                } else {
                    input.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Semua field kategori harus diisi!',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            }
        });

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

        // Initialize counter on page load
        updateCounter();
    </script>
@endpush
