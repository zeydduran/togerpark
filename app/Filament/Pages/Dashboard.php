<?php

namespace App\Filament\Pages;

use App\Models\ParkSession;
use App\Models\PaymentHistory;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = -2;

    public $dateRange = 'weekly';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->setDateRange();
    }

    public function setDateRange()
    {
        $now = Carbon::now();

        switch ($this->dateRange) {
            case 'daily':
                $this->startDate = $now->startOfDay();
                $this->endDate = $now->endOfDay();
                break;
            case 'weekly':
                $this->startDate = $now->startOfWeek();
                $this->endDate = $now->endOfWeek();
                break;
            case 'monthly':
                $this->startDate = $now->startOfMonth();
                $this->endDate = $now->endOfMonth();
                break;
        }
    }

    #[Computed]
    public function completedParks()
    {
        return ParkSession::where('company_id', Auth::user()->company_id)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    #[Computed]
    public function totalRevenue()
    {
        return PaymentHistory::where('company_id', Auth::user()->company_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('amount');
    }

    #[Computed]
    public function successfulCreditCardPayments()
    {
        return PaymentHistory::where('company_id', Auth::user()->company_id)
            ->where('method', 'credit_card')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();
    }

    #[Computed]
    public function dailyCompletedParks()
    {
        $data = ParkSession::where('company_id', Auth::user()->company_id)
            ->where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('count'),
        ];
    }

    #[Computed]
    public function paymentMethodDistribution()
    {
        $data = PaymentHistory::where('company_id', Auth::user()->company_id)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('method, COUNT(*) as count')
            ->groupBy('method')
            ->get();

        return [
            'labels' => $data->pluck('method'),
            'data' => $data->pluck('count'),
        ];
    }

    public function updateDateRange($range)
    {
        $this->dateRange = $range;
        $this->setDateRange();
    }

    protected function getViewData(): array
    {
        return [
            'completedParks' => $this->completedParks,
            'totalRevenue' => $this->totalRevenue,
            'successfulCreditCardPayments' => $this->successfulCreditCardPayments,
            'dailyCompletedParks' => $this->dailyCompletedParks,
            'paymentMethodDistribution' => $this->paymentMethodDistribution,
        ];
    }

    public function getView(): string
    {
        return 'filament.pages.dashboard';
    }
}
