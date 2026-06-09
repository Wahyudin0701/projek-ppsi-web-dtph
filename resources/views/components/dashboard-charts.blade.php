{{-- ===== CHARTS ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Tren Waktu --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="proposalChartComponent()">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-extrabold text-gray-800 text-lg">Tren Pengajuan Proposal</h3>
                <p class="text-xs text-gray-400 mt-0.5">Perbandingan pengajuan berdasarkan waktu</p>
            </div>
            <div class="inline-flex bg-gray-100 rounded-lg p-1">
                <button @click="setFilter('week')" :class="filter === 'week' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Minggu</button>
                <button @click="setFilter('month')" :class="filter === 'month' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Bulan</button>
                <button @click="setFilter('year')" :class="filter === 'year' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Tahun</button>
            </div>
        </div>
        
        <div x-ref="chart" id="chartContainer" class="w-full h-72"></div>
    </div>

    {{-- Distribusi Lokasi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="locationChartComponent()">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-extrabold text-gray-800 text-lg">Distribusi Lokasi</h3>
                <p class="text-xs text-gray-400 mt-0.5" x-text="getSubtitle()"></p>
            </div>
            <div x-show="level !== 'kecamatan'" x-cloak class="inline-flex">
                <button @click="goBack()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-bold rounded-lg transition-colors border border-gray-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </button>
            </div>
        </div>
        
        <div x-ref="locationChart" id="locationChartContainer" class="w-full h-72"></div>
    </div>
</div>

{{-- Kategori Alsintan & Jenis Program --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    {{-- Kategori Alsintan --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="categoryChartComponent()">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-extrabold text-gray-800 text-lg">Kategori Alsintan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Proporsi pengajuan berdasarkan kategori alat</p>
            </div>
            <div class="inline-flex bg-gray-100 rounded-lg p-1">
                <button @click="setFilter('week')" :class="filter === 'week' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Minggu</button>
                <button @click="setFilter('month')" :class="filter === 'month' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Bulan</button>
                <button @click="setFilter('year')" :class="filter === 'year' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Tahun</button>
            </div>
        </div>
        
        <div x-ref="categoryChart" id="categoryChartContainer" class="w-full h-72"></div>
    </div>

    {{-- Jenis Program --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="programCategoryChartComponent()">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-extrabold text-gray-800 text-lg">Jenis Program Bantuan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Proporsi pengajuan berdasarkan jenis program</p>
            </div>
            <div class="inline-flex bg-gray-100 rounded-lg p-1">
                <button @click="setFilter('week')" :class="filter === 'week' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Minggu</button>
                <button @click="setFilter('month')" :class="filter === 'month' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Bulan</button>
                <button @click="setFilter('year')" :class="filter === 'year' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Tahun</button>
            </div>
        </div>
        
        <div x-ref="programCategoryChart" id="programCategoryChartContainer" class="w-full h-72"></div>
    </div>
</div>

{{-- Status Penyelesaian Proposal --}}
<div class="mt-6 bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="statusChartComponent()">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="font-extrabold text-gray-800 text-lg">Status Penyelesaian Proposal</h3>
            <p class="text-xs text-gray-400 mt-0.5">Sebaran jumlah proposal berdasarkan status proses persetujuan saat ini</p>
        </div>
        <div class="inline-flex bg-gray-100 rounded-lg p-1">
            <button @click="setFilter('week')" :class="filter === 'week' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Minggu</button>
            <button @click="setFilter('month')" :class="filter === 'month' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Bulan</button>
            <button @click="setFilter('year')" :class="filter === 'year' ? 'bg-white shadow-sm text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-[10px] sm:text-xs rounded-md transition-all">Tahun</button>
        </div>
    </div>
    
    <div x-ref="statusChart" id="statusChartContainer" class="w-full h-72"></div>
</div>

@push('scripts')
<!-- Library ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Injeksi Data Backend yang Sangat Aman menggunakan Tag JSON -->
<script id="dashboard-chart-data" type="application/json">
    {!! json_encode($chartData ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
</script>

<script>
    // 1. Ambil dan parsing data JSON
    let rawChartData = [];
    try {
        const el = document.getElementById('dashboard-chart-data');
        if (el) {
            const parsed = JSON.parse(el.textContent || '[]');
            rawChartData = Array.isArray(parsed) ? parsed : Object.values(parsed);
        }
    } catch (e) {
        console.error("Gagal mem-parsing data chart JSON", e);
    }

    // 2. Registrasi Tren Waktu Langsung ke Window
    window.proposalChartComponent = function() {
        return {
            filter: 'year',
            chart: null,
            rawData: rawChartData,
            
            init() {
                const checkAndRender = () => {
                    try {
                        if (typeof window.ApexCharts !== 'undefined' && this.$refs.chart) {
                            this.renderChart();
                        } else {
                            setTimeout(checkAndRender, 100);
                        }
                    } catch (e) {
                        if (this.$refs.chart) {
                            this.$refs.chart.innerHTML = '<div class="text-red-500 text-xs p-4">' + e.message + '</div>';
                        }
                    }
                };
                checkAndRender();
            },
            
            setFilter(val) {
                this.filter = val;
                this.updateChart();
            },
            
            processData() {
                let seriesAlsintan = [];
                let seriesProgram = [];
                let categories = [];
                let now = new Date();
                
                if (this.filter === 'year') {
                    categories = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                    let countsA = new Array(12).fill(0);
                    let countsP = new Array(12).fill(0);
                    this.rawData.forEach(item => {
                        let d = new Date(item.date);
                        if (d.getFullYear() === now.getFullYear()) {
                            if (item.type === 'alsintan') countsA[d.getMonth()]++;
                            else countsP[d.getMonth()]++;
                        }
                    });
                    seriesAlsintan = countsA;
                    seriesProgram = countsP;
                } else if (this.filter === 'month') {
                    let daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
                    for (let i = 1; i <= daysInMonth; i++) {
                        categories.push(i);
                    }
                    let countsA = new Array(daysInMonth).fill(0);
                    let countsP = new Array(daysInMonth).fill(0);
                    this.rawData.forEach(item => {
                        let d = new Date(item.date);
                        if (d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth()) {
                            if (item.type === 'alsintan') countsA[d.getDate() - 1]++;
                            else countsP[d.getDate() - 1]++;
                        }
                    });
                    seriesAlsintan = countsA;
                    seriesProgram = countsP;
                } else if (this.filter === 'week') {
                    categories = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                    let countsA = new Array(7).fill(0);
                    let countsP = new Array(7).fill(0);
                    let currentDay = now.getDay();
                    let distanceToMonday = currentDay === 0 ? 6 : currentDay - 1;
                    let monday = new Date(now);
                    monday.setDate(now.getDate() - distanceToMonday);
                    monday.setHours(0,0,0,0);
                    let sunday = new Date(monday);
                    sunday.setDate(monday.getDate() + 6);
                    sunday.setHours(23,59,59,999);
                    
                    this.rawData.forEach(item => {
                        let d = new Date(item.date);
                        if (d >= monday && d <= sunday) {
                            let dayIndex = d.getDay() === 0 ? 6 : d.getDay() - 1;
                            if (item.type === 'alsintan') countsA[dayIndex]++;
                            else countsP[dayIndex]++;
                        }
                    });
                    seriesAlsintan = countsA;
                    seriesProgram = countsP;
                }
                return { categories, seriesAlsintan, seriesProgram };
            },
            
            renderChart() {
                const data = this.processData();
                const maxVal = Math.max(...data.seriesAlsintan, ...data.seriesProgram, 1);
                const options = {
                    series: [
                        { name: 'Alsintan', data: data.seriesAlsintan },
                        { name: 'Program Bantuan', data: data.seriesProgram }
                    ],
                    chart: { type: 'area', height: 320, fontFamily: 'Inter, sans-serif', toolbar: { show: false }, zoom: { enabled: false } },
                    colors: ['#0ea5e9', '#10b981'],
                    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 2 },
                    xaxis: { categories: data.categories, axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { colors: '#64748b', fontSize: '12px' } } },
                    yaxis: { min: 0, tickAmount: maxVal < 5 ? maxVal : 5, labels: { style: { colors: '#64748b', fontSize: '12px' }, formatter: (val) => parseInt(val) } },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4, yaxis: { lines: { show: true } }, xaxis: { lines: { show: false } } },
                    legend: { position: 'top', horizontalAlign: 'right', markers: { radius: 12 } }
                };
                
                this.chart = new window.ApexCharts(this.$refs.chart, options);
                this.chart.render();
            },
            
            updateChart() {
                if (this.chart) {
                    const data = this.processData();
                    const maxVal = Math.max(...data.seriesAlsintan, ...data.seriesProgram, 1);
                    this.chart.updateOptions({
                        series: [
                            { name: 'Alsintan', data: data.seriesAlsintan },
                            { name: 'Program Bantuan', data: data.seriesProgram }
                        ],
                        xaxis: { categories: data.categories },
                        yaxis: { min: 0, tickAmount: maxVal < 5 ? maxVal : 5, labels: { formatter: (val) => parseInt(val) } }
                    });
                }
            }
        };
    };

    // 3. Registrasi Distribusi Lokasi Langsung ke Window
    window.locationChartComponent = function() {
        return {
            level: 'kecamatan',
            selectedKecamatan: null,
            selectedDesa: null,
            chart: null,
            rawData: rawChartData,
            
            init() {
                const checkAndRender = () => {
                    try {
                        if (typeof window.ApexCharts !== 'undefined' && this.$refs.locationChart) {
                            this.renderChart();
                        } else {
                            setTimeout(checkAndRender, 100);
                        }
                    } catch (e) {
                        if (this.$refs.locationChart) {
                            this.$refs.locationChart.innerHTML = '<div class="text-red-500 text-xs p-4">' + e.message + '</div>';
                        }
                    }
                };
                checkAndRender();
            },
            
            getSubtitle() {
                if (this.level === 'kecamatan') return 'Pengajuan berdasarkan Kecamatan (Top 10)';
                if (this.level === 'desa') return 'Pengajuan di Kec. ' + this.selectedKecamatan + ' (Top 10)';
                return 'Pengajuan di ' + this.selectedDesa + ' (Top 10)';
            },
            
            goBack() {
                if (this.level === 'kelompok') {
                    this.level = 'desa';
                    this.selectedDesa = null;
                } else if (this.level === 'desa') {
                    this.level = 'kecamatan';
                    this.selectedKecamatan = null;
                }
                this.updateChart();
            },

            processData() {
                let counts = {};
                this.rawData.forEach(item => {
                    let k = item.kecamatan || 'Lainnya';
                    let d = item.desa || 'Lainnya';
                    let kel = item.kelompok || 'Lainnya';
                    
                    if (this.level === 'kecamatan') {
                        counts[k] = (counts[k] || 0) + 1;
                    } else if (this.level === 'desa') {
                        if (k === this.selectedKecamatan) {
                            counts[d] = (counts[d] || 0) + 1;
                        }
                    } else if (this.level === 'kelompok') {
                        if (k === this.selectedKecamatan && d === this.selectedDesa) {
                            counts[kel] = (counts[kel] || 0) + 1;
                        }
                    }
                });
                
                let sortedArray = Object.keys(counts).map(key => ({ loc: key, count: counts[key] })).sort((a, b) => b.count - a.count);
                let topArray = sortedArray.slice(0, 10);
                
                return {
                    categories: topArray.map(item => item.loc),
                    seriesData: topArray.map(item => item.count)
                };
            },
            
            renderChart() {
                const data = this.processData();
                const maxVal = Math.max(...data.seriesData, 1);
                const self = this;
                
                const options = {
                    series: [{ name: 'Jumlah Proposal', data: data.seriesData }],
                    chart: { 
                        type: 'bar', 
                        height: 280, 
                        fontFamily: 'Inter, sans-serif', 
                        toolbar: { show: false },
                        events: {
                            dataPointSelection: function(event, chartContext, config) {
                                if (config.dataPointIndex >= 0) {
                                    let catName = chartContext.w.config.xaxis.categories[config.dataPointIndex];
                                    if (self.level === 'kecamatan') {
                                        self.selectedKecamatan = catName;
                                        self.level = 'desa';
                                        self.updateChart();
                                    } else if (self.level === 'desa') {
                                        self.selectedDesa = catName;
                                        self.level = 'kelompok';
                                        self.updateChart();
                                    }
                                }
                            }
                        }
                    },
                    colors: ['#4f46e5'],
                    plotOptions: { 
                        bar: { 
                            borderRadius: 4, 
                            horizontal: true,
                            dataLabels: { position: 'top' }
                        } 
                    },
                    states: { hover: { filter: { type: 'darken', value: 0.9 } } },
                    dataLabels: { enabled: false },
                    xaxis: { min: 0, tickAmount: maxVal < 5 ? maxVal : 5, categories: data.categories, labels: { style: { colors: '#64748b', fontSize: '11px' }, formatter: (val) => parseInt(val) } },
                    yaxis: { labels: { style: { colors: '#475569', fontSize: '12px', fontWeight: 600 } } },
                    grid: { borderColor: '#f1f5f9', xaxis: { lines: { show: true } }, yaxis: { lines: { show: false } } },
                    tooltip: {
                        theme: 'light',
                        y: { formatter: function (val) { return val + " Proposal" } }
                    }
                };
                
                this.chart = new window.ApexCharts(this.$refs.locationChart, options);
                this.chart.render();
            },

            updateChart() {
                if (this.chart) {
                    const data = this.processData();
                    const maxVal = Math.max(...data.seriesData, 1);
                    
                    let color = '#4f46e5';
                    if (this.level === 'desa') color = '#0ea5e9';
                    if (this.level === 'kelompok') color = '#10b981';
                    
                    this.chart.updateOptions({
                        colors: [color],
                        series: [{ name: 'Jumlah Proposal', data: data.seriesData }],
                        xaxis: { min: 0, tickAmount: maxVal < 5 ? maxVal : 5, categories: data.categories, labels: { formatter: (val) => parseInt(val) } }
                    });
                }
            }
        };
    };

    // 4. Registrasi Grafik Kategori Alsintan Langsung ke Window
    window.categoryChartComponent = function() {
        return {
            filter: 'year',
            chart: null,
            rawData: rawChartData,
            
            init() {
                const checkAndRender = () => {
                    try {
                        if (typeof window.ApexCharts !== 'undefined' && this.$refs.categoryChart) {
                            this.renderChart();
                        } else {
                            setTimeout(checkAndRender, 100);
                        }
                    } catch (e) {
                        if (this.$refs.categoryChart) {
                            this.$refs.categoryChart.innerHTML = '<div class="text-red-500 text-xs p-4">' + e.message + '</div>';
                        }
                    }
                };
                checkAndRender();
            },
            
            setFilter(val) {
                this.filter = val;
                this.updateChart();
            },

            processData() {
                let counts = {};
                let now = new Date();
                
                let monday = new Date(now);
                let currentDay = now.getDay();
                let distanceToMonday = currentDay === 0 ? 6 : currentDay - 1;
                monday.setDate(now.getDate() - distanceToMonday);
                monday.setHours(0,0,0,0);
                
                let sunday = new Date(monday);
                sunday.setDate(monday.getDate() + 6);
                sunday.setHours(23,59,59,999);

                this.rawData.forEach(item => {
                    if (item.type === 'alsintan') {
                        let d = new Date(item.date);
                        let include = false;
                        
                        if (this.filter === 'year' && d.getFullYear() === now.getFullYear()) {
                            include = true;
                        } else if (this.filter === 'month' && d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth()) {
                            include = true;
                        } else if (this.filter === 'week' && d >= monday && d <= sunday) {
                            include = true;
                        }

                        if (include) {
                            let cat = item.kategori_alat || 'Lainnya';
                            counts[cat] = (counts[cat] || 0) + 1;
                        }
                    }
                });
                
                let sortedArray = Object.keys(counts).map(key => ({ label: key, count: counts[key] })).sort((a, b) => b.count - a.count);
                
                return {
                    labels: sortedArray.map(item => item.label),
                    series: sortedArray.map(item => item.count)
                };
            },
            
            renderChart() {
                const data = this.processData();
                
                if (data.series.length === 0) {
                    this.$refs.categoryChart.innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm font-medium bg-gray-50 rounded-xl">Belum ada data pengajuan Alsintan</div>';
                    return;
                }

                const options = {
                    series: data.series,
                    labels: data.labels,
                    chart: { type: 'donut', height: 280, fontFamily: 'Inter, sans-serif' },
                    colors: ['#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6', '#d946ef', '#f43f5e', '#f97316'],
                    plotOptions: { 
                        pie: { 
                            donut: { 
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: { fontSize: '12px', color: '#64748b' },
                                    value: { fontSize: '24px', fontWeight: 700, color: '#1e293b' },
                                    total: { show: true, label: 'Total Pengajuan', color: '#64748b', fontSize: '13px', fontWeight: 600 }
                                }
                            } 
                        } 
                    },
                    dataLabels: { enabled: false },
                    stroke: { width: 4, colors: ['#ffffff'] },
                    legend: { position: 'right', fontSize: '13px', markers: { radius: 12 } },
                    tooltip: { theme: 'light', y: { formatter: function (val) { return val + " Proposal" } } }
                };
                
                this.chart = new window.ApexCharts(this.$refs.categoryChart, options);
                this.chart.render();
            },
            
            updateChart() {
                if (this.chart) {
                    const data = this.processData();
                    
                    if (data.series.length === 0) {
                        this.$refs.categoryChart.innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm font-medium bg-gray-50 rounded-xl">Belum ada data pada periode ini</div>';
                        this.chart = null;
                        return;
                    }
                    
                    this.chart.updateOptions({
                        series: data.series,
                        labels: data.labels
                    });
                } else if (this.$refs.categoryChart) {
                    this.$refs.categoryChart.innerHTML = '';
                    this.renderChart();
                }
            }
        };
    };

    // 5. Registrasi Grafik Jenis Program Langsung ke Window
    window.programCategoryChartComponent = function() {
        return {
            filter: 'year',
            chart: null,
            rawData: rawChartData,
            
            init() {
                const checkAndRender = () => {
                    try {
                        if (typeof window.ApexCharts !== 'undefined' && this.$refs.programCategoryChart) {
                            this.renderChart();
                        } else {
                            setTimeout(checkAndRender, 100);
                        }
                    } catch (e) {
                        if (this.$refs.programCategoryChart) {
                            this.$refs.programCategoryChart.innerHTML = '<div class="text-red-500 text-xs p-4">' + e.message + '</div>';
                        }
                    }
                };
                checkAndRender();
            },
            
            setFilter(val) {
                this.filter = val;
                this.updateChart();
            },

            processData() {
                let counts = {};
                let now = new Date();
                
                let monday = new Date(now);
                let currentDay = now.getDay();
                let distanceToMonday = currentDay === 0 ? 6 : currentDay - 1;
                monday.setDate(now.getDate() - distanceToMonday);
                monday.setHours(0,0,0,0);
                
                let sunday = new Date(monday);
                sunday.setDate(monday.getDate() + 6);
                sunday.setHours(23,59,59,999);

                this.rawData.forEach(item => {
                    if (item.type === 'program') {
                        let d = new Date(item.date);
                        let include = false;
                        
                        if (this.filter === 'year' && d.getFullYear() === now.getFullYear()) {
                            include = true;
                        } else if (this.filter === 'month' && d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth()) {
                            include = true;
                        } else if (this.filter === 'week' && d >= monday && d <= sunday) {
                            include = true;
                        }

                        if (include) {
                            let cat = item.kategori_program || 'Lainnya';
                            counts[cat] = (counts[cat] || 0) + 1;
                        }
                    }
                });
                
                let sortedArray = Object.keys(counts).map(key => ({ label: key, count: counts[key] })).sort((a, b) => b.count - a.count);
                
                return {
                    labels: sortedArray.map(item => item.label),
                    series: sortedArray.map(item => item.count)
                };
            },
            
            renderChart() {
                const data = this.processData();
                
                if (data.series.length === 0) {
                    this.$refs.programCategoryChart.innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm font-medium bg-gray-50 rounded-xl">Belum ada data pengajuan Program</div>';
                    return;
                }

                const options = {
                    series: data.series,
                    labels: data.labels,
                    chart: { type: 'donut', height: 280, fontFamily: 'Inter, sans-serif' },
                    colors: ['#10b981', '#34d399', '#059669', '#047857', '#065f46', '#064e3b', '#6ee7b7'],
                    plotOptions: { 
                        pie: { 
                            donut: { 
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: { fontSize: '12px', color: '#64748b' },
                                    value: { fontSize: '24px', fontWeight: 700, color: '#1e293b' },
                                    total: { show: true, label: 'Total Pengajuan', color: '#64748b', fontSize: '13px', fontWeight: 600 }
                                }
                            } 
                        } 
                    },
                    dataLabels: { enabled: false },
                    stroke: { width: 4, colors: ['#ffffff'] },
                    legend: { position: 'right', fontSize: '13px', markers: { radius: 12 } },
                    tooltip: { theme: 'light', y: { formatter: function (val) { return val + " Proposal" } } }
                };
                
                this.chart = new window.ApexCharts(this.$refs.programCategoryChart, options);
                this.chart.render();
            },
            
            updateChart() {
                if (this.chart) {
                    const data = this.processData();
                    
                    if (data.series.length === 0) {
                        this.$refs.programCategoryChart.innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm font-medium bg-gray-50 rounded-xl">Belum ada data pada periode ini</div>';
                        this.chart = null;
                        return;
                    }
                    
                    this.chart.updateOptions({
                        series: data.series,
                        labels: data.labels
                    });
                } else if (this.$refs.programCategoryChart) {
                    this.$refs.programCategoryChart.innerHTML = '';
                    this.renderChart();
                }
            }
        };
    };

    // 6. Registrasi Grafik Status Penyelesaian Proposal
    window.statusChartComponent = function() {
        return {
            filter: 'year',
            chart: null,
            rawData: rawChartData,
            
            init() {
                const checkAndRender = () => {
                    try {
                        if (typeof window.ApexCharts !== 'undefined' && this.$refs.statusChart) {
                            this.renderChart();
                        } else {
                            setTimeout(checkAndRender, 100);
                        }
                    } catch (e) {
                        if (this.$refs.statusChart) {
                            this.$refs.statusChart.innerHTML = '<div class="text-red-500 text-xs p-4">' + e.message + '</div>';
                        }
                    }
                };
                checkAndRender();
            },
            
            setFilter(val) {
                this.filter = val;
                this.updateChart();
            },

            processData() {
                let statusOrder = [
                    { id: 'sedang_diverifikasi_admin',    label: 'Di Admin' },
                    { id: 'sedang_diverifikasi_pimpinan', label: 'Di Pimpinan' },
                    { id: 'persiapan_survei',             label: 'Di Kabid' },
                    { id: 'sedang_survei',                label: 'Sedang Survei' },
                    { id: 'verifikasi_cpcl',              label: 'Verifikasi CPCL' },
                    { id: 'menunggu_keputusan_akhir',     label: 'Finalisasi' },
                    { id: 'direkomendasikan',             label: 'Rek. Pusat' },
                    { id: 'disetujui',                    label: 'Disetujui' },
                    { id: 'dikembalikan',                 label: 'Selesai' },
                    { id: 'ditolak',                      label: 'Ditolak' },
                    { id: 'ditolak_pusat',                label: 'Ditolak Pusat' },
                ];
                
                let counts = {};
                statusOrder.forEach(s => counts[s.label] = 0);
                
                let now = new Date();
                let monday = new Date(now);
                let currentDay = now.getDay();
                let distanceToMonday = currentDay === 0 ? 6 : currentDay - 1;
                monday.setDate(now.getDate() - distanceToMonday);
                monday.setHours(0,0,0,0);
                
                let sunday = new Date(monday);
                sunday.setDate(monday.getDate() + 6);
                sunday.setHours(23,59,59,999);

                this.rawData.forEach(item => {
                    let d = new Date(item.date);
                    let include = false;
                    
                    if (this.filter === 'year' && d.getFullYear() === now.getFullYear()) {
                        include = true;
                    } else if (this.filter === 'month' && d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth()) {
                        include = true;
                    } else if (this.filter === 'week' && d >= monday && d <= sunday) {
                        include = true;
                    }

                    if (include && item.status) {
                        let statusObj = statusOrder.find(s => s.id === item.status);
                        if (statusObj) {
                            counts[statusObj.label] = (counts[statusObj.label] || 0) + 1;
                        }
                    }
                });
                
                return {
                    categories: statusOrder.map(s => s.label),
                    series: statusOrder.map(s => counts[s.label])
                };
            },
            
            renderChart() {
                const data = this.processData();
                const maxVal = Math.max(...data.series, 1);
                
                // Color each status bar distinctly
                const barColors = [
                    '#f59e0b', // Di Admin       - amber
                    '#6366f1', // Di Pimpinan    - indigo
                    '#f97316', // Di Kabid       - orange
                    '#3b82f6', // Sedang Survei  - blue
                    '#0ea5e9', // Verifikasi CPCL - sky
                    '#8b5cf6', // Finalisasi     - violet
                    '#10b981', // Rek. Pusat     - emerald
                    '#22c55e', // Disetujui      - green
                    '#94a3b8', // Selesai        - slate
                    '#f43f5e', // Ditolak        - rose
                    '#b91c1c', // Ditolak Pusat  - dark red
                ];

                const options = {
                    series: [{ name: 'Jumlah Proposal', data: data.series }],
                    chart: { type: 'bar', height: 280, fontFamily: 'Inter, sans-serif', toolbar: { show: false } },
                    colors: barColors,
                    plotOptions: { 
                        bar: { 
                            borderRadius: 4, 
                            horizontal: false,
                            columnWidth: '60%',
                            distributed: true,
                            dataLabels: { position: 'top' }
                        } 
                    },
                    dataLabels: { 
                        enabled: true,
                        formatter: function (val) { return val > 0 ? val : ''; },
                        offsetY: -20,
                        style: { fontSize: '10px', colors: ["#64748b"] }
                    },
                    xaxis: { 
                        categories: data.categories, 
                        labels: { 
                            style: { colors: '#64748b', fontSize: '10px' },
                            rotate: -35,
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: { 
                        min: 0, 
                        tickAmount: maxVal < 5 ? maxVal : 5, 
                        labels: { style: { colors: '#64748b', fontSize: '12px' }, formatter: (val) => parseInt(val) } 
                    },
                    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                    legend: { show: false },
                    tooltip: { theme: 'light', y: { formatter: function (val) { return val + " Proposal" } } }
                };
                
                this.chart = new window.ApexCharts(this.$refs.statusChart, options);
                this.chart.render();
            },
            
            updateChart() {
                if (this.chart) {
                    const data = this.processData();
                    const maxVal = Math.max(...data.series, 1);
                    
                    this.chart.updateOptions({
                        series: [{ name: 'Jumlah Proposal', data: data.series }],
                        xaxis: { categories: data.categories },
                        yaxis: { min: 0, tickAmount: maxVal < 5 ? maxVal : 5 }
                    });
                }
            }
        };
    };
</script>
@endpush
