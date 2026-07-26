<x-seller-layout title="Buat Iklan">

    <div class="bg-white shadow-md rounded-lg p-6">

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h2 class="text-lg font-semibold text-gray-800 mb-1">Buat Iklan</h2>
            <p class="text-sm text-gray-500 mb-5">Isi detail kendaraan yang ingin kamu jual.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                <div>
                    <label for="title" class="block mb-1 text-sm font-medium text-gray-900">Judul Iklan</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                           placeholder="Contoh: Toyota Avanza 2020 Mulus">
                </div>

                <div>
                    <label for="category_id" class="block mb-1 text-sm font-medium text-gray-900">Kategori</label>
                    <select name="category_id" id="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="" disabled selected>Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="brand" class="block mb-1 text-sm font-medium text-gray-900">Merek</label>
                    <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                           placeholder="Contoh: Toyota">
                </div>

                <div>
                    <label for="model" class="block mb-1 text-sm font-medium text-gray-900">Model</label>
                    <input type="text" name="model" id="model" value="{{ old('model') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                           placeholder="Contoh: Avanza">
                </div>

                <div>
                    <label for="price" class="block mb-1 text-sm font-medium text-gray-900">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" min="0"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                           placeholder="150000000">
                </div>

                <div>
                    <label for="year" class="block mb-1 text-sm font-medium text-gray-900">Tahun</label>
                    <input type="number" name="year" id="year" value="{{ old('year') }}" min="1980" max="{{ date('Y') + 1 }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                           placeholder="2020">
                </div>

                <div>
                    <label for="condition" class="block mb-1 text-sm font-medium text-gray-900">Kondisi</label>
                    <select name="condition" id="condition"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option value="bekas" @selected(old('condition', 'bekas') == 'bekas')>Bekas</option>
                        <option value="baru" @selected(old('condition') == 'baru')>Baru</option>
                    </select>
                </div>

                <div>
                    <label for="location" class="block mb-1 text-sm font-medium text-gray-900">Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                           placeholder="Contoh: Malang, Jawa Timur">
                </div>
            </div>

            <!-- Deskripsi: full width -->
            <div class="mt-5">
                <label for="description" class="block mb-1 text-sm font-medium text-gray-900">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                          placeholder="Jelaskan kondisi, kelengkapan surat, riwayat servis, dll">{{ old('description') }}</textarea>
            </div>

            <!-- Upload foto: full width -->
            <div class="mt-5">
                <label for="images" class="block mb-1 text-sm font-medium text-gray-900">Foto Kendaraan</label>
                <input type="file" name="images[]" id="images" multiple accept="image/png,image/jpeg,image/jpg"
                    class="block w-full text-sm text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 focus:outline-none">
                <p class="mt-1 text-xs text-gray-500">
                    Minimal <strong>3 foto</strong>: tampak depan, samping kanan, dan samping kiri. Format JPG/PNG, maksimal 20MB per foto.
                </p>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-4 border-t">
                <button type="submit"
                        class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Simpan Iklan
                </button>
                <a href="{{ route('vehicles.my-vehicles') }}"
                   class="text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-seller-layout>