@extends('layouts-admin.admin')

@section('title', 'Category Edit')

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
                    Edit Category
                </h2>
                <p class="text-sm text-slate-500">Perbarui informasi kategori yang sudah ada</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="category_name" class="block text-sm font-medium text-slate-700 mb-2">
                Category Name <span class="text-red-500">*</span>
            </label>
            <input type="text" id="category_name" name="category_name"
                   value="{{ old('category_name', $category->category_name) }}"
                   class="w-full px-4 py-3 border border-slate-200 rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                          placeholder:text-slate-400 @error('category_name') border-red-500 @enderror"
                   placeholder="Masukkan nama kategori">
            @error('category_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-50">
            <button type="submit"
                    class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg
                           transition font-medium shadow-sm flex items-center">
                <i class="fa-solid fa-save mr-2"></i>
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection