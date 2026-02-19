<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrTransaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = QrTransaction::query()
            ->with(['user', 'shop.category'])
            ->latest('scanned_at')
            ->paginate(20);

        return view('admin.transactions.index', [
            'transactions' => $transactions,
        ]);
    }
}
