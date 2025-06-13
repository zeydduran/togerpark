<?php

namespace App\Filament\Pages;

use App\Models\ParkSession;
use App\Models\PaymentHistory;
use Filament\Pages\Page;

class Report extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Raporlar';
    protected static ?string $navigationLabel = 'Raporlar';
    protected static ?string $pluralNavigationLabel = 'Raporlar';
    protected static ?string $modelLabel = 'Rapor';
    protected static ?string $pluralModelLabel = 'Raporlar';
    protected static string $view = 'filament.pages.report';

    public $totalIncome;
    public $totalSessions;
    public $paymentBreakdown;

    public function mount(): void
    {
        $companyId = auth()->user()->company_id;

        $this->totalIncome = PaymentHistory::where('company_id', $companyId)->sum('amount');
        $this->totalSessions = ParkSession::where('company_id', $companyId)->count();
        $this->paymentBreakdown = PaymentHistory::where('company_id', $companyId)
            ->selectRaw('method, COUNT(*) as count')
            ->groupBy('method')
            ->pluck('count', 'method');
    }
}
