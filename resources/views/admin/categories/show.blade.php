@extends('layouts-admin.admin')

@section('title', 'KATEGORI')

@section('content')

<div class="bg-white rounded-xl shadow p-5 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.categories.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-slate-900">
                    Show Category
                </h2>
                <p class="text-sm text-slate-500">Detail informasi data kategori</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-slate-900 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-circle-info text-sky-500"></i>
        Category Information
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">ID Kategori</label>
                <p class="text-lg font-bold text-sky-600">#{{ $category->id }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">Nama Kategori</label>
                <p class="text-xl font-semibold text-slate-900">{{ $category->category_name }}</p>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">Tanggal Dibuat</label>
                <div class="flex items-center gap-2 text-slate-700">
                    <i class="fa-regular fa-calendar text-sky-400"></i>
                    <p class="text-lg">{{ $category->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">Terakhir Diperbarui</label>
                <div class="flex items-center gap-2 text-slate-700">
                    <i class="fa-regular fa-clock text-sky-400"></i>
                    <p class="text-lg">{{ $category->updated_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection