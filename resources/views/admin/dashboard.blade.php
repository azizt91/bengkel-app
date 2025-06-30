<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold mb-4">Welcome, {{ auth()->user()->name }}</h1>
            <!-- Statistik Utama -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-gray-500">Total Booking</div>
                            <div class="text-3xl font-bold">{{ $bookingCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-gray-500">Booking Bulan Ini</div>
                            <div class="text-3xl font-bold">{{ $monthlyBookings }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-gray-500">Pendapatan Bulan Ini</div>
                            <div class="text-3xl font-bold">Rp {{ number_format($monthlyRevenue,0,',','.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-gray-500">Teknisi</div>
                            <div class="text-3xl font-bold">{{ $technicians->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Pembayaran Harian -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Pendapatan Harian</h2>
                <canvas id="paymentChart"></canvas>

                @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    
                    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
                    const paymentData = @json($paymentStats);
                    new Chart(paymentCtx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(paymentData),
                            datasets: [{
                                label: 'Pendapatan (Rp)',
                                data: Object.values(paymentData),
                                backgroundColor: '#4f46e5'
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    ticks: {
                                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                                    }
                                }
                            }
                        }
                    });
                    </script>
                @endpush
            </div>

            <!-- Grafik Top Spare Parts & Services -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Top Spare Parts (Qty)</h2>
                    <canvas id="partsChart"></canvas>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4">Top Services (Qty)</h2>
                    <canvas id="servicesChart"></canvas>
                </div>
            </div>

            <!-- Teknisi Terbaik -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Teknisi Terbaik</h2>
                <div class="space-y-4">
                    @foreach($technicians->sortByDesc('completed_bookings_count')->take(3) as $technician)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium">{{ $technician->user->name }}</div>
                                <div class="text-sm text-gray-600">{{ $technician->completed_bookings_count }} selesai</div>
                            </div>
                            <div class="text-2xl font-bold text-green-600">{{ $technician->bookings_count }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('paymentChart').getContext('2d');
        const labels = @json($paymentStats->pluck('date'));
        const data = {
            labels: labels,
            datasets: [{
                label: 'Pendapatan Harian',
                data: @json($paymentStats->pluck('total_amount')),
                borderColor: 'rgb(79, 70, 229)',
                tension: 0.1
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        }
                    }
                }
            }
        });

        // Top Parts Chart
        const partChartData = @json($topParts);
        new Chart(document.getElementById('partsChart'), {
            type: 'bar',
            data: {
                labels: partChartData.map(p=>p.name),
                datasets:[{label:'Qty', data: partChartData.map(p=>p.qty), backgroundColor:'#10b981'}]
            },
            options:{indexAxis:'y'}
        });

        const serviceChartData = @json($topServices);
        new Chart(document.getElementById('servicesChart'), {
            type: 'bar',
            data: {
                labels: serviceChartData.map(s=>s.description),
                datasets:[{label:'Qty', data: serviceChartData.map(s=>s.qty), backgroundColor:'#f59e0b'}]
            },
            options:{indexAxis:'y'}
        });
    </script>
    @endpush
</x-app-layout>
