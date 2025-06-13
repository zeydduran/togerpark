<x-filament-panels::page>
 <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-filament::card>
            <h2 class="text-lg font-bold">Toplam Gelir</h2>
            <p class="text-2xl font-semibold text-green-600">{{ number_format($totalIncome, 2) }} ₺</p>
        </x-filament::card>

        <x-filament::card>
            <h2 class="text-lg font-bold">Toplam Oturum</h2>
            <p class="text-2xl font-semibold">{{ $totalSessions }}</p>
        </x-filament::card>

        <x-filament::card>
            <h2 class="text-lg font-bold">Ödeme Dağılımı</h2>
            <ul>
                @foreach ($paymentBreakdown as $method => $count)
                    <li>{{ strtoupper($method) }}: {{ $count }}</li>
                @endforeach
            </ul>
        </x-filament::card>
    </div>
</x-filament-panels::page>
