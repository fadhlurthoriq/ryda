<x-public-layout title="Ryda — Jual Beli Mobil & Motor Bekas">

    <!-- Hero -->
    <section class="scroll-mt-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col justify-center items-center min-h-screen">
                <div class="flex flex-col justify-center items-center gap-4 text-center max-w-3xl mx-auto mt-32 pb-12">
                    <span class="badge-pill">✨ Marketplace kendaraan bekas #1</span>
                    <h1 class="text-5xl lg:text-6xl font-semibold title-gradient">
                        Temukan Kendaraan Impianmu di Ryda
                    </h1>
                    <p class="text-xl text-neutral-600">
                        Jual beli mobil dan motor bekas dengan mudah, aman, dan terpercaya.
                    </p>
                    <div class="flex justify-center items-center gap-4 mt-8">
                        <a href="{{ route('register') }}" class="btn-pill bg-neutral-900 text-white hover:bg-neutral-800">
                            Mulai Jelajahi
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="btn-pill bg-neutral-100 text-neutral-700 hover:bg-neutral-200">
                            Lihat Kategori
                        </a>
                    </div>
                </div>

                <div class="overflow-hidden">
                    <img src="{{ asset('images/auth-login.png') }}" alt="Kendaraan pilihan di Ryda" class="w-full h-auto max-h-[420px] object-cover">
                </div>
            </div>
        </div>
    </section>

    <x-features-section
        title="Dibuat Buat Kamu yang Serius Cari Kendaraan"
        description="Kami memastikan setiap transaksi jual beli kendaraan berjalan aman dan nyaman."
        :features="[
            ['icon' => '<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>', 'title' => 'Penjual Terverifikasi', 'description' => 'Setiap penjual melalui proses verifikasi sebelum memasang iklan.'],
            ['icon' => '<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z\'/></svg>', 'title' => 'Chat Langsung', 'description' => 'Nego dan tanya-tanya langsung ke penjual secara real-time.'],
            ['icon' => '<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>', 'title' => 'Transaksi Aman', 'description' => 'Setiap pembelian tercatat rapi lengkap dengan struk digital.'],
        ]"
    />

    <x-cta-section
        badge="Buat Pembeli"
        title="Cari Mobil Impian Jadi Lebih Gampang"
        description="Jelajahi ribuan mobil bekas dari penjual terverifikasi, lengkap dengan detail kondisi dan riwayat kendaraan."
        :points="[
            ['title' => 'Filter Sesuai Kebutuhan', 'description' => 'Cari berdasarkan merek, harga, tahun, dan lokasi.'],
            ['title' => 'Nego Langsung ke Penjual', 'description' => 'Chat real-time, nggak perlu nunggu balasan lama.'],
        ]"
        button-label="Mulai Cari Mobil"
        button-url="{{ route('register') }}"
        image="{{ asset('images/auth-login.png') }}"
        image-alt="Cari mobil di Ryda"
    />

    <x-cta-section
        badge="Buat Penjual"
        title="Jual Motor Bekasmu Lebih Cepat Laku"
        description="Pasang iklan lengkap dengan foto dan detail kendaraan, pantau semua transaksi dari satu dashboard."
        :points="[
            ['title' => 'Kelola Banyak Iklan', 'description' => 'Pantau status tiap kendaraan: tersedia atau terjual.'],
            ['title' => 'Riwayat Transaksi Rapi', 'description' => 'Lengkap dengan struk digital tiap kendaraan yang laku.'],
        ]"
        button-label="Mulai Jual Kendaraan"
        button-url="{{ route('register') }}"
        image="{{ asset('images/auth-register.png') }}"
        image-alt="Jual motor di Ryda"
        :reverse="true"
    />

    <x-testimonials-section
        title="Dipercaya Ribuan Pengguna"
        description="Cerita dari pembeli dan penjual yang udah pakai Ryda."
        :testimonials="[
            ['initials' => 'RS', 'name' => 'Rizky Saputra', 'role' => 'Pembeli Mobil', 'content' => 'Proses beli mobil bekas jadi jauh lebih gampang. Chat langsung sama penjualnya bikin nego cepat.'],
            ['initials' => 'DA', 'name' => 'Dewi Anggraini', 'role' => 'Penjual Motor', 'content' => 'Motor bekas aku laku dalam 3 hari. Fitur upload fotonya gampang dan pembelinya beneran serius.'],
            ['initials' => 'AF', 'name' => 'Andi Firmansyah', 'role' => 'Pembeli Motor', 'content' => 'Struk digitalnya rapi banget, jadi ada bukti transaksi yang jelas pas beli motor bekas.'],
        ]"
        button-label="Gabung Sekarang"
        button-url="{{ route('register') }}"
    />

    <!-- FAQ -->
    <section class="bg-neutral-50 py-24">
        <div class="max-w-5xl mx-auto px-4">
            <div class="bg-white border border-neutral-200 rounded-3xl p-8 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div>
                        <h2 class="text-4xl font-semibold text-neutral-900">Pertanyaan yang Sering Diajukan</h2>
                        <p class="mt-3 text-neutral-600">Belum ketemu jawaban yang kamu cari? Hubungi tim kami.</p>
                        <a href="#" class="inline-flex items-center gap-1 text-sm font-medium text-gold-600 hover:underline mt-4">
                            Hubungi Kami
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>

                    <div>
                        <x-faq-item question="Gimana cara beli kendaraan di Ryda?" answer="Cari kendaraan yang kamu suka, buka halaman detailnya, lalu klik &quot;Beli Sekarang&quot; atau hubungi penjual dulu lewat fitur chat kalau mau nego." />
                        <x-faq-item question="Gimana cara jual kendaraan?" answer="Kamu perlu akun dengan role penjual. Setelah itu tinggal buat iklan lengkap dengan foto dan detail kendaraan dari dashboard penjual." />
                        <x-faq-item question="Apakah transaksi di Ryda aman?" answer="Setiap transaksi tercatat dengan invoice unik dan status yang jelas (pending, selesai, dibatalkan), jadi ada bukti transaksi yang jelas buat kedua pihak." />
                        <x-faq-item question="Apakah bisa nego harga sebelum beli?" answer="Bisa banget, tinggal klik &quot;Hubungi Penjual&quot; di halaman detail kendaraan buat mulai chat langsung sama penjualnya." />
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>