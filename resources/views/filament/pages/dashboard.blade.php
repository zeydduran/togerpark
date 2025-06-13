<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Tarih Filtresi --}}
        <div class="flex justify-end space-x-2 gap-3">

            <x-filament::button
                wire:click="updateDateRange('daily')"
                :color="$dateRange === 'daily' ? 'primary' : 'gray'"
            >
                Günlük
            </x-filament::button>
            <x-filament::button
                wire:click="updateDateRange('weekly')"
                :color="$dateRange === 'weekly' ? 'primary' : 'gray'"
            >
                Haftalık
            </x-filament::button>
            <x-filament::button
                wire:click="updateDateRange('monthly')"
                :color="$dateRange === 'monthly' ? 'primary' : 'gray'"
            >
                Aylık
            </x-filament::button>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Tamamlanan Park</h3>
                        <p class="mt-1 text-3xl font-semibold text-primary-600">{{ $completedParks }}</p>
                    </div>
                    <div class="rounded-full bg-primary-100 p-3">
                        <x-heroicon-o-check-circle class="h-6 w-6 text-primary-600" />
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Toplam Gelir</h3>
                        <p class="mt-1 text-3xl font-semibold text-primary-600">{{ number_format($totalRevenue, 2) }} ₺</p>
                    </div>
                    <div class="rounded-full bg-primary-100 p-3">
                        <x-heroicon-o-currency-dollar class="h-6 w-6 text-primary-600" />
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Kredi Kartı İşlemleri</h3>
                        <p class="mt-1 text-3xl font-semibold text-primary-600">{{ $successfulCreditCardPayments }}</p>
                    </div>
                    <div class="rounded-full bg-primary-100 p-3">
                        <x-heroicon-o-credit-card class="h-6 w-6 text-primary-600" />
                    </div>
                </div>
            </x-filament::card>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <x-filament::card>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Günlük Tamamlanan Park Sayısı</h3>
                <div class="h-[300px]">
                    <canvas x-data x-init="
                        new Chart($el, {
                            type: 'bar',
                            data: {
                                labels: {{ json_encode($dailyCompletedParks['labels']) }},
                                datasets: [{
                                    label: 'Tamamlanan Park',
                                    data: {{ json_encode($dailyCompletedParks['data']) }},
                                    backgroundColor: '#6366f1',
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        })
                    "></canvas>
                </div>
            </x-filament::card>

            <x-filament::card>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ödeme Yöntemi Dağılımı</h3>
                <div class="h-[300px]">
                    <canvas x-data x-init="
                        new Chart($el, {
                            type: 'pie',
                            data: {
                                labels: {{ json_encode($paymentMethodDistribution['labels']) }},
                                datasets: [{
                                    data: {{ json_encode($paymentMethodDistribution['data']) }},
                                    backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444']
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                            }
                        })
                    "></canvas>
                </div>
            </x-filament::card>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-filament-panels::page>
