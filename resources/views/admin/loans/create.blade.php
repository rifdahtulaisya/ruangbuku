@extends('layouts-admin.admin')

@section('title', 'TRANSAKSI')

@section('content')
    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.loans.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Tambah Pinjaman</h1>
                <p class="text-sm text-slate-500">Tambahkan data pinjaman buku baru</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="bg-white rounded-xl shadow p-6 flex-1">
            <form id="loanForm" action="{{ route('admin.loans.store') }}" method="POST">
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

                <div class="space-y-4">
                    {{-- Pilih User --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <i class="fa-solid fa-user mr-2 text-sky-500"></i>
                            Nama Peminjam <span class="text-red-500">*</span>
                        </label>
                        <select name="id_users" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                                   focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                                   bg-white">
                            <option value="">-- Pilih Peminjam --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('id_users') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_users')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pilih Buku --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <i class="fa-solid fa-book mr-2 text-sky-500"></i>
                            Judul Buku <span class="text-red-500">*</span>
                        </label>
                        <select name="id_books" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                                   focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                                   bg-white">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ old('id_books') == $book->id ? 'selected' : '' }}
                                    data-stock="{{ $book->stock }}">
                                    {{ $book->title }} (Stok: {{ $book->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_books')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p id="stock-warning" class="text-xs text-amber-600 mt-1 hidden">
                            <i class="fa-solid fa-triangle-exclamation"></i> Stok buku tersisa sedikit!
                        </p>
                    </div>

                    {{-- Tanggal Pinjam --}}
<div>
    <label class="block text-sm font-medium text-slate-700 mb-2">
        <i class="fa-solid fa-calendar-day mr-2 text-sky-500"></i>
        Tanggal Pinjam <span class="text-red-500">*</span>
    </label>
    {{-- Menggunakan Carbon untuk mendapatkan tanggal hari ini di zona waktu Jakarta --}}
    <input type="date" name="tgl_pinjam" 
        value="{{ old('tgl_pinjam', \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d')) }}" 
        required
        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-sky-400">
    @error('tgl_pinjam')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Tanggal Kembali Rencana --}}
<div>
    <label class="block text-sm font-medium text-slate-700 mb-2">
        <i class="fa-solid fa-calendar-week mr-2 text-sky-500"></i>
        Tanggal Kembali Rencana <span class="text-red-500">*</span>
    </label>
    {{-- Dikosongkan (tanpa value default) sesuai permintaan Anda --}}
    <input type="date" name="tgl_kembali_rencana" 
        value="{{ old('tgl_kembali_rencana') }}" 
        required
        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-sky-300 focus:border-sky-400">
    @error('tgl_kembali_rencana')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
    @enderror
</div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <i class="fa-solid fa-flag mr-2 text-sky-500"></i>
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg
                                   focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                                   bg-white">
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="borrowed" {{ old('status') == 'borrowed' ? 'selected' : '' }}>Borrowed (Dipinjam)</option>
                            <option value="returned" {{ old('status') == 'returned' ? 'selected' : '' }}>Returned (Dikembalikan)</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                        </select>
                        <p class="text-xs text-amber-600 mt-1">
                            <i class="fa-solid fa-info-circle"></i> 
                            Jika status "Borrowed" dipilih, stok buku akan langsung berkurang
                        </p>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100 mt-6">
                    <a href="{{ route('admin.loans.index') }}"
                        class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-700
                               hover:bg-slate-50 transition flex items-center gap-2">
                        <i class="fa-solid fa-times"></i>
                        Batal
                    </a>
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
                        <i class="fa-solid fa-hand-holding-heart text-6xl text-sky-500"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Buat Peminjaman Baru</h3>
                    <p class="text-sm text-slate-500">Pastikan data peminjam dan buku sudah benar.</p>
                    <div class="mt-4 p-3 bg-sky-50 rounded-lg">
                        <p class="text-xs text-slate-600">
                            <i class="fa-solid fa-clock mr-1"></i>
                            Lama peminjaman standar: 7 hari
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const form = document.getElementById('loanForm');
        const bookSelect = document.querySelector('select[name="id_books"]');
        const statusSelect = document.querySelector('select[name="status"]');
        const stockWarning = document.getElementById('stock-warning');
        const tglPinjam = document.querySelector('input[name="tgl_pinjam"]');
        const tglKembaliRencana = document.querySelector('input[name="tgl_kembali_rencana"]');

       // Cek stok buku saat memilih buku
function checkBookStock() {
    const selectedOption = bookSelect.options[bookSelect.selectedIndex];
    if (selectedOption && selectedOption.value) {
        const stock = parseInt(selectedOption.dataset.stock);
        
        // Stok seharusnya tidak akan 0 karena data sudah difilter di controller
        // Tapi tetap dicek untuk keamanan
        if (stock <= 0) {
            stockWarning.classList.remove('hidden');
            stockWarning.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> Stok buku habis! Tidak bisa meminjam.`;
            stockWarning.classList.add('text-red-600');
            
            // Nonaktifkan tombol submit atau beri warning
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;
        } else if (stock < 3) {
            stockWarning.classList.remove('hidden');
            stockWarning.classList.remove('text-red-600');
            stockWarning.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> Stok buku tersisa ${stock}!`;
            
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = false;
        } else {
            stockWarning.classList.add('hidden');
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = false;
        }
    } else {
        stockWarning.classList.add('hidden');
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = false;
    }
}

        bookSelect.addEventListener('change', checkBookStock);

        // Validasi tanggal kembali tidak boleh kurang dari tanggal pinjam
        function validateDates() {
            if (tglPinjam.value && tglKembaliRencana.value) {
                if (tglKembaliRencana.value < tglPinjam.value) {
                    tglKembaliRencana.setCustomValidity('Tanggal kembali tidak boleh kurang dari tanggal pinjam');
                    tglKembaliRencana.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                } else {
                    tglKembaliRencana.setCustomValidity('');
                    tglKembaliRencana.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                }
            }
        }

        tglPinjam.addEventListener('change', validateDates);
        tglKembaliRencana.addEventListener('change', validateDates);

        // Validasi sebelum submit
        form.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Validasi stok jika status borrowed
            if (statusSelect.value === 'borrowed') {
                const selectedOption = bookSelect.options[bookSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const stock = parseInt(selectedOption.dataset.stock);
                    if (stock < 1) {
                        isValid = false;
                        errorMessage = 'Stok buku tidak mencukupi! Tidak dapat meminjam buku ini.';
                    }
                }
            }

            // Validasi tanggal
            if (tglKembaliRencana.value < tglPinjam.value) {
                isValid = false;
                errorMessage = 'Tanggal kembali tidak boleh kurang dari tanggal pinjam!';
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage,
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Tampilkan SweetAlert success jika ada session success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0ea5e9',
                confirmButtonText: 'OK'
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

        // Initial check for stock warning
        checkBookStock();
        validateDates();
    </script>
@endpush