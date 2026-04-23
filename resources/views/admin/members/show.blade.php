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
                <h1 class="text-xl font-semibold text-slate-900">Detail Anggota</h1>
                <p class="text-sm text-stone-500">Informasi lengkap anggota yang dipilih</p>
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

    <!-- DETAIL CARD -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <!-- Header with Avatar/Icon -->
        <div class="relative bg-gradient-to-r from-sky-600 to-sky-800 h-32 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative text-center">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 backdrop-blur-sm">
                    <i class="fa-solid fa-user text-5xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <!-- Username -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-user-circle mr-1"></i> Username
                        </label>
                        <p class="text-stone-800 font-medium">{{ $member->username }}</p>
                    </div>

                    <!-- Full Name -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-user mr-1"></i> Nama Lengkap
                        </label>
                        <p class="text-stone-800 font-medium">{{ $member->name }}</p>
                    </div>

                    <!-- Member Number -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-id-card mr-1"></i> Nomor Anggota
                        </label>
                        <p class="text-stone-800 font-medium">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-sky-100 text-sky-800">
                                {{ $member->number }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <!-- Email -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-envelope mr-1"></i> Email
                        </label>
                        <p class="text-stone-800">
                            <a href="mailto:{{ $member->email }}" class="text-sky-600 hover:text-sky-700 hover:underline">
                                {{ $member->email }}
                            </a>
                        </p>
                    </div>

                    <!-- Created At -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-regular fa-calendar-plus mr-1"></i> Bergabung Pada
                        </label>
                        <p class="text-stone-800">
                            {{ $member->created_at ? $member->created_at->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>

                    <!-- Last Updated -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-regular fa-calendar-check mr-1"></i> Terakhir Diupdate
                        </label>
                        <p class="text-stone-800">
                            {{ $member->updated_at ? $member->updated_at->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-trash text-red-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-center text-slate-800 mb-2">Hapus Anggota</h3>
                <p class="text-center text-stone-600 mb-6" id="deleteMessage">
                    Apakah Anda yakin ingin menghapus anggota <strong id="memberName"></strong>?
                </p>
                <div class="flex gap-3 justify-center">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-lg border border-stone-300 text-stone-700 hover:bg-stone-50 transition">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(memberId, memberName) {
            const modal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const memberNameSpan = document.getElementById('memberName');
            
            // Set form action URL
            deleteForm.action = "{{ route('admin.members.index') }}/" + memberId;
            
            // Set member name in message
            memberNameSpan.textContent = memberName;
            
            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endpush