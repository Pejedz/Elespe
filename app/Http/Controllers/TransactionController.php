<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::query()
            ->with('user')
            ->orderByDesc('date')
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['details.item.category', 'user']);

        return view('transactions.show', compact('transaction'));
    }

    public function print(Transaction $transaction): View
    {
        $transaction->load(['details.item', 'user']);

        return view('transactions.print', compact('transaction'));
    }
}
