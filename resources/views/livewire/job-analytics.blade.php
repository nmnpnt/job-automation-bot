<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2">
        <h2 class="text-2xl font-bold text-white tracking-tight flex items-center">
            <div class="w-10 h-10 bg-brand-500/10 rounded-xl flex items-center justify-center mr-3 shadow-inner border border-brand-500/20">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            Application Analytics
        </h2>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Applications -->
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-[0_0_15px_rgba(0,0,0,0.5)] rounded-3xl p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-neon-cyan/10 rounded-full blur-2xl group-hover:bg-neon-cyan/20 transition-all duration-500"></div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Applications</p>
            <p class="mt-2 text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">{{ number_format($totalApplications) }}</p>
            <div class="mt-4 flex items-center text-sm text-neon-cyan font-bold">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                All time record
            </div>
        </div>

        <!-- This Week -->
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-[0_0_15px_rgba(0,0,0,0.5)] rounded-3xl p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-500/10 rounded-full blur-2xl group-hover:bg-brand-500/20 transition-all duration-500"></div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">This Week</p>
            <p class="mt-2 text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">{{ number_format($thisWeekApplications) }}</p>
            <div class="mt-4 flex items-center text-sm text-brand-400 font-bold">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Last 7 days
            </div>
        </div>

        <!-- Interview Rate -->
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-[0_0_15px_rgba(0,0,0,0.5)] rounded-3xl p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-neon-pink/10 rounded-full blur-2xl group-hover:bg-neon-pink/20 transition-all duration-500"></div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Interview/Offer Rate</p>
            <p class="mt-2 text-4xl font-black text-white drop-shadow-[0_0_8px_rgba(255,255,255,0.3)]">{{ $interviewRate }}%</p>
            <div class="mt-4 flex items-center text-sm text-slate-500 font-bold">
                Based on total applications
            </div>
        </div>
    </div>

    <!-- Charts Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Application Trends -->
        <div class="lg:col-span-2 bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-[0_0_15px_rgba(0,0,0,0.5)] rounded-3xl p-6 relative overflow-hidden group">
            <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-6 flex items-center">
                <svg class="w-4 h-4 mr-2 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                Application Trends (Last 7 Days)
            </h3>
            <div class="relative h-72 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-[0_0_15px_rgba(0,0,0,0.5)] rounded-3xl p-6 relative overflow-hidden group">
            <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-6 flex items-center">
                <svg class="w-4 h-4 mr-2 text-neon-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                Status Breakdown
            </h3>
            <div class="relative h-60 w-full flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Source Breakdown -->
        <div class="lg:col-span-3 bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-[0_0_15px_rgba(0,0,0,0.5)] rounded-3xl p-6 relative overflow-hidden group">
            <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-6 flex items-center">
                <svg class="w-4 h-4 mr-2 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Application Sources
            </h3>
            <div class="relative h-64 w-full">
                <canvas id="sourceChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            
            Chart.defaults.color = '#94a3b8'; // slate-400
            Chart.defaults.font.family = "'Inter', sans-serif";
            
            // Trend Chart
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: {!! $trendDates !!},
                    datasets: [{
                        label: 'Applications',
                        data: {!! $trendData !!},
                        borderColor: '#8b5cf6', // brand-500
                        backgroundColor: 'rgba(139, 92, 246, 0.15)',
                        borderWidth: 3,
                        pointBackgroundColor: '#030014',
                        pointBorderColor: '#8b5cf6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: { 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            border: { dash: [4, 4] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Status Pie Chart
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! $statusLabels !!},
                    datasets: [{
                        data: {!! $statusData !!},
                        backgroundColor: [
                            '#8b5cf6', // purple-500 (Applied)
                            '#22d3ee', // neon-cyan (Interviewing)
                            '#10b981', // emerald-500 (Offer)
                            '#ff2a85', // neon-pink (Rejected)
                            '#f59e0b', // amber-500 (Ghosted)
                            '#64748b'  // slate-500 (Other)
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: { 
                    maintainAspectRatio: false, 
                    plugins: { 
                        legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, color: '#e2e8f0' } }
                    },
                    cutout: '75%'
                }
            });

            // Source Bar Chart
            new Chart(document.getElementById('sourceChart'), {
                type: 'bar',
                data: {
                    labels: {!! $sourceLabels !!},
                    datasets: [{
                        label: 'Count',
                        data: {!! $sourceData !!},
                        backgroundColor: '#22d3ee', // neon-cyan
                        borderRadius: 6,
                        barPercentage: 0.5
                    }]
                },
                options: { 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            border: { dash: [4, 4] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</div>
