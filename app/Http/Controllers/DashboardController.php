<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $dailySales = $this->getDailySales();
        $weeklySales = $this->getWeeklySales();
        $monthlySales = $this->getMonthlySales();
        $yearlySales = $this->getYearlySales();  // Added yearly sales

        $dailyPurchases = $this->getDailyPurchases();
        $weeklyPurchases = $this->getWeeklyPurchases();
        $monthlyPurchases = $this->getMonthlyPurchases();
        $yearlyPurchases = $this->getYearlyPurchases();  // Added yearly purchases

        return view('dashboard', compact('dailySales', 'weeklySales', 'monthlySales', 'yearlySales', 'dailyPurchases', 'weeklyPurchases', 'monthlyPurchases', 'yearlyPurchases'));
    }

    private function getDailySales()
    {
        return Penjualan::selectRaw('DATE(created_at) as date, SUM(total_harga) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
    }

    private function getWeeklySales()
    {
        return Penjualan::selectRaw('YEARWEEK(created_at) as week, SUM(total_harga) as total')
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->limit(5)
            ->get();
    }

    private function getMonthlySales()
    {
        return Penjualan::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_harga) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(5)
            ->get();
    }

    private function getYearlySales()
    {
        return Penjualan::selectRaw('YEAR(created_at) as year, SUM(total_harga) as total')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->limit(5)
            ->get();
    }

    private function getDailyPurchases()
    {
        return Pembelian::selectRaw('DATE(created_at) as date, SUM(total_harga) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
    }

    private function getWeeklyPurchases()
    {
        return Pembelian::selectRaw('YEARWEEK(created_at) as week, SUM(total_harga) as total')
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->limit(5)
            ->get();
    }

    private function getMonthlyPurchases()
    {
        return Pembelian::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_harga) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(5)
            ->get();
    }

    private function getYearlyPurchases()
    {
        return Pembelian::selectRaw('YEAR(created_at) as year, SUM(total_harga) as total')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->limit(5)
            ->get();
    }
}

