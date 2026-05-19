<x-layouts.public>
    <x-slot:title>Katalog Alsintan - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Jelajahi daftar Alat dan Mesin Pertanian (Alsintan) yang tersedia untuk dipinjam oleh kelompok tani binaan Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen" x-data="alsintanCatalog()" @keydown.escape.window="drawer = false">

        {{-- Hero Section --}}
        <div class="bg-white py-12 text-center border-b border-gray-100">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight pb-6">Katalog Alsintan</h1>
            <div class="w-16 h-1 bg-primary-500 mx-auto rounded-full"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-sm md:text-base px-4 leading-relaxed font-medium">
                Daftar lengkap Alat dan Mesin Pertanian (Alsintan) yang tersedia untuk mendukung aktivitas kelompok tani di Kabupaten Muaro Jambi.
            </p>

            {{-- Search Bar --}}
            <div class="mt-8 max-w-xl mx-auto px-4 group">
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" x-model="searchQuery"
                        placeholder="Cari nama alat, merk... "
                        class="w-full pl-4 pr-12 py-3.5 rounded-2xl border border-gray-200 bg-white text-gray-800 placeholder-gray-400 focus:border-primary-400 focus:ring-4 focus:ring-primary-400/10 transition-all shadow-sm text-sm font-medium">
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Filter Row --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-10">

                {{-- Dropdown Filter Kategori --}}
                <div class="relative">
                    <label class="sr-only">Filter Kategori</label>
                    <select x-model="activeCategory"
                        class="bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl pl-4 pr-10 py-2.5 shadow-sm focus:border-primary-400 focus:ring-2 focus:ring-primary-400/10 transition-all cursor-pointer">
                        <template x-for="category in categories" :key="category.id">
                            <option :value="category.id" x-text="category.name"></option>
                        </template>
                    </select>
                </div>

                {{-- Result count --}}
                <span class="text-sm text-gray-400 font-medium" x-show="filteredItems.length > 0">
                    Menampilkan <strong class="text-gray-700" x-text="filteredItems.length"></strong> unit alsintan
                </span>
            </div>

            {{-- Alsintan Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="item in filteredItems" :key="item.id">
                    <div @click="openDrawer(item.id)" class="cursor-pointer bg-white rounded-[2rem] overflow-hidden border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.10)] transition-all duration-500 group flex flex-col hover:-translate-y-1.5">

                        {{-- Image --}}
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                            {{-- Status Badge --}}
                            <div class="absolute top-4 left-4">
                                <span x-show="item.status === 'tersedia'" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-emerald-700 text-xs font-bold border border-emerald-100 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                                <span x-show="item.status === 'tidak_tersedia'" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-amber-700 text-xs font-bold border border-amber-100 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Dipinjam
                                </span>
                                <span x-show="item.status === 'rusak'" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-red-700 text-xs font-bold border border-red-100 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Rusak
                                </span>
                            </div>

                            {{-- Category Tag --}}
                            <div class="absolute top-4 right-4">
                                <span class="px-2.5 py-1 bg-black/30 backdrop-blur-sm text-white/90 text-[10px] font-bold rounded-full uppercase tracking-wider" x-text="getCategoryName(item.category_id)"></span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 sm:p-7 flex flex-col flex-1">
                            <h3 class="text-base font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors" x-text="item.name"></h3>
                            <p class="text-sm text-gray-500 leading-relaxed mb-5 line-clamp-2" x-text="item.description"></p>

                            {{-- Specs --}}
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Merk / Tipe</p>
                                    <p class="text-sm font-bold text-gray-800 truncate" x-text="item.merk"></p>
                                </div>
                                <div class="bg-gray-50 border border-gray-100 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Kapasitas</p>
                                    <p class="text-sm font-bold text-gray-800 truncate" x-text="item.capacity"></p>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="flex items-center justify-between pt-5 mt-auto border-t border-gray-50">
                                <span class="text-xs text-gray-400 font-medium">
                                    Stok: <strong class="text-gray-700" x-text="item.stock + ' unit'"></strong>
                                </span>
                                <template x-if="item.available_stock > 0">
                                    <div>
                                        @auth
                                            @if(auth()->user()->isApproved())
                                                <a :href="`{{ route('farmer.proposals.programs') }}?kategori_pengajuan=alsintan&alsintan_id=${item.id}`" @click.stop
                                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                                    Ajukan Pinjaman
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                </a>
                                            @else
                                                <a href="{{ route('dashboard') }}" @click.stop
                                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                                    Ajukan Pinjaman
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" @click.stop
                                               class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                                Ajukan Pinjaman
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        @endauth
                                    </div>
                                </template>
                                <template x-if="item.available_stock <= 0">
                                    <div class="flex gap-2">
                                        <template x-if="item.borrowed_count > 0">
                                            <span class="text-xs font-bold text-amber-600">Sedang Dipinjam</span>
                                        </template>
                                        <template x-if="item.broken_count > 0 && item.borrowed_count === 0">
                                            <span class="text-xs font-bold text-red-600">Dalam Perbaikan</span>
                                        </template>
                                        <template x-if="item.borrowed_count === 0 && item.broken_count === 0">
                                            <span class="text-xs font-bold text-gray-500">Stok Habis</span>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Empty State --}}
            <div x-show="filteredItems.length === 0" x-cloak class="text-center py-24">
                <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center mb-5 border border-gray-200 shadow-sm">
                    <svg class="w-9 h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ditemukan</h3>
                <p class="text-gray-400 text-sm mb-5">Alsintan yang Anda cari tidak tersedia saat ini.</p>
                <button @click="searchQuery = ''; activeCategory = 'all'" class="text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">
                    Tampilkan Semua
                </button>
            </div>

            {{-- Info Banner --}}
            <div class="mt-16 bg-primary-600 rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-xl shadow-primary-600/20">
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0 border border-white/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2 tracking-tight">Tidak Menemukan Alsintan yang Sesuai?</h3>
                        <p class="text-white/90 text-sm md:text-base max-w-lg leading-relaxed font-medium">
                            Silakan hubungi kami untuk informasi ketersediaan alsintan yang tidak tercantum atau untuk pengajuan kebutuhan khusus kelompok tani Anda.
                        </p>
                    </div>
                </div>
                
                <div class="relative z-10 flex-shrink-0 w-full md:w-auto">
                    <a href="{{ route('kontak') }}" class="inline-flex justify-center w-full md:w-auto items-center gap-2 px-8 py-4 bg-white text-primary-600 hover:bg-primary-50 font-bold text-sm rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-xl">
                        Hubungi Kami
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>

        {{-- Slide-over Drawer --}}
        <div x-show="drawer" x-cloak class="fixed inset-0 z-50 flex justify-start" @click.self="drawer = false">
            {{-- Backdrop --}}
            <div x-show="drawer" x-transition.opacity.duration.300ms class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="drawer = false"></div>

            {{-- Panel --}}
            <div x-show="drawer"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-250 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="drawer-panel relative w-full max-w-lg bg-white h-full overflow-y-auto shadow-2xl flex flex-col"
                 style="scrollbar-width: none; -ms-overflow-style: none;">

                {{-- Drawer Header --}}
                <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-100 px-6 py-4 flex items-center justify-between z-10">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Detail Alsintan</span>
                    <button @click="drawer = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-red-100 hover:text-red-500 text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Drawer Body --}}
                <template x-if="selected">
                    <div class="flex-1">
                        {{-- Large Image --}}
                        <div class="h-64 bg-gray-100 relative">
                            <img :src="selected.image" :alt="selected.name" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>

                        <div class="p-6">
                            {{-- Category & Status --}}
                            <div class="flex items-center gap-3 mb-5">
                                <span class="px-2.5 py-1 bg-primary-50 text-primary-600 text-[10px] font-bold rounded-full uppercase tracking-wider border border-primary-100" x-text="getCategoryName(selected.category_id)"></span>
                                <template x-if="selected.status === 'tersedia'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Tersedia
                                    </span>
                                </template>
                                <template x-if="selected.status === 'tidak_tersedia'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Dipinjam
                                    </span>
                                </template>
                                <template x-if="selected.status === 'rusak'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-[10px] font-bold border border-red-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Rusak
                                    </span>
                                </template>
                            </div>

                            {{-- Title --}}
                            <h2 class="text-2xl font-black text-gray-900 leading-tight mb-4" x-text="selected.name"></h2>

                            {{-- Description --}}
                            <p class="text-gray-500 leading-relaxed text-sm mb-8" x-text="selected.description"></p>

                            {{-- Specs Grid --}}
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Spesifikasi Teknis</h3>
                            <div class="grid grid-cols-2 gap-3 mb-8">
                                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Merk / Tipe</p>
                                    <p class="text-sm font-bold text-gray-900" x-text="selected.merk"></p>
                                </div>
                                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Kapasitas</p>
                                    <p class="text-sm font-bold text-gray-900" x-text="selected.capacity"></p>
                                </div>
                                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 col-span-2">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-2">Ketersediaan Unit</p>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="text-center bg-white rounded-xl p-2 border border-gray-100 shadow-sm">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Total</p>
                                            <p class="text-sm font-black text-gray-900" x-text="selected.stock"></p>
                                        </div>
                                        <div class="text-center bg-amber-50 rounded-xl p-2 border border-amber-100 shadow-sm">
                                            <p class="text-[10px] font-bold text-amber-600 uppercase">Dipinjam</p>
                                            <p class="text-sm font-black text-amber-700" x-text="selected.borrowed_count"></p>
                                        </div>
                                        <div class="text-center bg-emerald-50 rounded-xl p-2 border border-emerald-100 shadow-sm">
                                            <p class="text-[10px] font-bold text-emerald-600 uppercase">Tersedia</p>
                                            <p class="text-sm font-black text-emerald-700" x-text="selected.available_stock"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="bg-primary-50 rounded-2xl p-5 border border-primary-100">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-xs text-primary-700 leading-relaxed">
                                        Peminjaman alsintan ini hanya berlaku bagi kelompok tani yang terdaftar di wilayah Kabupaten Muaro Jambi dan telah diverifikasi oleh petugas PPL setempat.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Drawer Footer --}}
                <div class="sticky bottom-0 bg-white border-t border-gray-100 p-5 flex gap-3">
                    <template x-if="selected && selected.available_stock > 0">
                        @auth
                            @if(auth()->user()->isApproved())
                                <a :href="'{{ url('farmer/proposals/alsintan') }}/' + selected.id" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-2xl text-sm font-bold text-center transition-colors shadow-lg shadow-primary-600/20">
                                    Ajukan Pinjaman Sekarang
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-2xl text-sm font-bold text-center transition-colors shadow-lg shadow-primary-600/20">
                                    Lengkapi Profil Untuk Meminjam
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3.5 rounded-2xl text-sm font-bold text-center transition-colors shadow-lg shadow-primary-600/20">
                                Ajukan Pinjaman Sekarang
                            </a>
                        @endauth
                    </template>
                    <template x-if="selected && selected.available_stock <= 0">
                        <div class="flex-1 bg-gray-100 text-gray-500 py-3.5 rounded-2xl text-sm font-bold text-center border border-gray-200 cursor-not-allowed">
                            Saat ini Stok Tidak Tersedia
                        </div>
                    </template>
                    <button @click="drawer = false" class="px-5 py-3.5 border border-gray-200 rounded-2xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .drawer-panel::-webkit-scrollbar { display: none; }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alsintanCatalog', () => ({
                searchQuery: '',
                activeCategory: 'all',
                filteredItems: [],
                drawer: false,
                selected: null,
                categories: [
                    { id: 'all',        name: 'Semua Kategori' },
                    { id: 'traktor',    name: 'Traktor' },
                    { id: 'pompa',      name: 'Pompa Air' },
                    { id: 'pascapanen', name: 'Pasca Panen' },
                    { id: 'tanam',      name: 'Alat Tanam' },
                ],
                items: @json($alsintans).map(item => ({
                    id: item.id,
                    category_id: item.category ? item.category.toLowerCase() : 'lainnya',
                    name: item.name,
                    merk: item.merk || '-',
                    capacity: item.capacity || '-',
                    stock: item.stock,
                    available_stock: item.available_stock,
                    borrowed_count: item.borrowed_count,
                    broken_count: item.broken_count,
                    description: item.description || '',
                    status: item.available_stock > 0 ? 'tersedia' : (item.borrowed_count > 0 ? 'tidak_tersedia' : (item.broken_count > 0 ? 'rusak' : 'tidak_tersedia')),
                    image: item.image ? '{{ asset("storage") }}/' + item.image : 'https://picsum.photos/seed/' + item.id + '/800/500'
                })),
                init() {
                    this.filteredItems = [...this.items];
                    this.$watch('searchQuery',    () => this.applyFilters());
                    this.$watch('activeCategory', () => this.applyFilters());
                    this.$watch('drawer', val => {
                        document.body.style.overflow = val ? 'hidden' : '';
                    });
                },
                applyFilters() {
                    const query = this.searchQuery.toLowerCase().trim();
                    this.filteredItems = this.items.filter(item => {
                        const catOk    = this.activeCategory === 'all' || item.category_id === this.activeCategory;
                        const searchOk = !query ||
                                         item.name.toLowerCase().includes(query) ||
                                         item.merk.toLowerCase().includes(query);
                        return catOk && searchOk;
                    });
                },
                openDrawer(id) {
                    this.selected = this.items.find(i => i.id === id) || null;
                    this.drawer = true;
                },
                getCategoryName(id) {
                    const cat = this.categories.find(c => c.id === id);
                    return cat ? cat.name : '';
                }
            }));
        });
    </script>
</x-layouts.public>
