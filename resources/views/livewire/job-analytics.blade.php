<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-6 flex items-center text-gray-800">
        <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        Application Analytics
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Application Trends -->
        <div class="lg:col-span-3 bg-gray-50 p-4 rounded-lg border border-gray-100">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Applications Last 7 Days</h3>
            <div class="relative h-64 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Status Breakdown</h3>
            <div class="relative h-48 w-full flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Source Breakdown -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 lg:col-span-2">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Application Sources</h3>
            <div class="relative h-48 w-full">
                <canvas id="sourceChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            // Trend Chart
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: {!! $trendDates !!},
                    datasets: [{
                        label: 'Applications',
                        data: {!! $trendData !!},
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            // Status Pie Chart
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! $statusLabels !!},
                    datasets: [{
                        data: {!! $statusData !!},
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#6b7280']
                    }]
                },
                options: { maintainAspectRatio: false, plugins: { legend: { position: 'right' } } }
            });

            // Source Bar Chart
            new Chart(document.getElementById('sourceChart'), {
                type: 'bar',
                data: {
                    labels: {!! $sourceLabels !!},
                    datasets: [{
                        label: 'Count',
                        data: {!! $sourceData !!},
                        backgroundColor: '#3b82f6'
                    }]
                },
                options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        });
    </script>
</div>
