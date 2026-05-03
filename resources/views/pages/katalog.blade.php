<x-layouts.public>
    <x-slot:title>Katalog Alsintan - DTPH Muaro Jambi</x-slot:title>
    <x-slot:metaDescription>Jelajahi daftar Alat dan Mesin Pertanian (Alsintan) yang tersedia untuk dipinjam oleh kelompok tani binaan Dinas Tanaman Pangan dan Hortikultura Kabupaten Muaro Jambi.</x-slot:metaDescription>

    <div class="bg-[#f8faf9] min-h-screen" x-data="alsintanCatalog()">

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
                    <div class="bg-white rounded-[2rem] overflow-hidden border border-gray-100 shadow-[0_6px_30px_-10px_rgba(0,0,0,0.06)] hover:shadow-[0_16px_40px_-10px_rgba(0,0,0,0.10)] transition-all duration-500 group flex flex-col hover:-translate-y-1.5">

                        {{-- Image --}}
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                            {{-- Status Badge --}}
                            <div class="absolute top-4 left-4">
                                <span x-show="item.stock > 0" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-emerald-700 text-xs font-bold border border-emerald-100 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                                <span x-show="item.stock === 0" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-amber-700 text-xs font-bold border border-amber-100 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Dipinjam
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
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-600 hover:text-primary-700 transition-all hover:translate-x-0.5">
                                    Ajukan Pinjaman
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
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
            <div class="mt-16 bg-primary-600 rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 overflow-hidden shadow-xl shadow-primary-600/20">
                <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">Tidak Menemukan Alsintan yang Sesuai?</h3>
                        <p class="text-white/90 text-sm md:text-base max-w-lg leading-relaxed font-medium">
                            Hubungi Dinas DTPH untuk informasi ketersediaan alsintan yang tidak tercantum atau untuk pengajuan kebutuhan khusus kelompok tani Anda.
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 w-full md:w-auto">
                    <a href="#" class="inline-flex justify-center w-full md:w-auto items-center gap-2 px-8 py-4 bg-white text-primary-600 hover:bg-primary-50 font-bold text-sm rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-xl">
                        Hubungi Dinas
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('alsintanCatalog', () => ({
                searchQuery: '',
                activeCategory: 'all',
                filteredItems: [],
                categories: [
                    { id: 'all',        name: 'Semua Kategori' },
                    { id: 'traktor',    name: 'Traktor' },
                    { id: 'pompa',      name: 'Pompa Air' },
                    { id: 'pascapanen', name: 'Pasca Panen' },
                    { id: 'tanam',      name: 'Alat Tanam' },
                ],
                items: [
                    {
                        id: 1, category_id: 'traktor',
                        name: 'Traktor Roda 4',
                        merk: 'Kubota L1-24', capacity: '24 HP', stock: 2,
                        description: 'Traktor roda 4 tangguh untuk pengolahan lahan sawah dan lahan kering. Dilengkapi rotary tiller dan kabin pelindung operator.',
                        image: 'https://picsum.photos/seed/traktor4/800/500'
                    },
                    {
                        id: 2, category_id: 'traktor',
                        name: 'Hand Tractor (Traktor Tangan)',
                        merk: 'Yanmar YZC', capacity: '8.5 HP', stock: 5,
                        description: 'Hand traktor serbaguna untuk lahan terasering dan sawah berlumpur sempit. Mudah dioperasikan dan konsumsi bahan bakar irit.',
                        image: 'https://picsum.photos/seed/handtractor/800/500'
                    },
                    {
                        id: 3, category_id: 'pompa',
                        name: 'Pompa Air 3 Inch',
                        merk: 'Honda WB30XN', capacity: '1.100 L/menit', stock: 0,
                        description: 'Pompa air irigasi bertenaga mesin bensin 4-tak. Ideal untuk mengairi lahan tadah hujan dan lahan jauh dari sumber air.',
                        image: 'https://picsum.photos/seed/waterpump/800/500'
                    },
                    {
                        id: 4, category_id: 'pascapanen',
                        name: 'Combine Harvester Mini',
                        merk: 'Quick Zaga-V', capacity: '0.1 Ha/Jam', stock: 1,
                        description: 'Mesin pemanen padi mini yang cocok untuk petakan sawah kecil hingga menengah. Meminimalisir gabah yang rontok saat panen.',
                        image: 'https://picsum.photos/seed/harvester/800/500'
                    },
                    {
                        id: 5, category_id: 'tanam',
                        name: 'Rice Transplanter',
                        merk: 'Yanmar AP4', capacity: '4 Alur', stock: 1,
                        description: 'Mesin tanam padi otomatis dengan jarak tanam presisi, mengurangi tenaga kerja secara signifikan.',
                        image: 'https://picsum.photos/seed/transplanter/800/500'
                    },
                    {
                        id: 6, category_id: 'pascapanen',
                        name: 'Power Thresher',
                        merk: 'Crown', capacity: '800 Kg/Jam', stock: 3,
                        description: 'Mesin perontok padi dengan efisiensi tinggi. Hasil gabah lebih bersih dan susut pasca panen dapat ditekan secara maksimal.',
                        image: 'https://picsum.photos/seed/thresher/800/500'
                    },
                ],
                init() {
                    this.filteredItems = [...this.items];
                    this.$watch('searchQuery',    () => this.applyFilters());
                    this.$watch('activeCategory', () => this.applyFilters());
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
                getCategoryName(id) {
                    const cat = this.categories.find(c => c.id === id);
                    return cat ? cat.name : '';
                }
            }));
        });
    </script>
</x-layouts.public>
