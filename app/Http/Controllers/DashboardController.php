<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalCategories' => Category::query()->count(),
            'totalItems' => Item::query()->count(),
            'totalTransactions' => Transaction::query()->count(),
        ]);
    }
}
