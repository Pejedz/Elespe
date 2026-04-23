<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartItemRequest;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PosController extends Controller
{
    private const LOW_STOCK_THRESHOLD = 5;

    public function __construct(
        private readonly CartService $cart
    ) {}

    public function index(): View
    {
        $items = Item::query()
            ->with('category')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        $cartLines = $this->cart->lines();
        $cartTotal = $this->cart->total();
        $lowStockThreshold = self::LOW_STOCK_THRESHOLD;

        return view('pos.index', compact('items', 'cartLines', 'cartTotal', 'lowStockThreshold'));
    }

    public function addToCart(AddCartItemRequest $request): RedirectResponse
    {
        $item = Item::query()->findOrFail($request->validated('item_id'));
        $qty = (int) $request->validated('qty');
        $current = $this->cart->getQuantities()[$item->id] ?? 0;

        if ($current + $qty > $item->stock) {
            $available = max(0, $item->stock - $current);

            throw ValidationException::withMessages([
                "add_qty_{$item->id}" => "Stok tidak cukup (tersedia: {$available}).",
            ]);
        }

        $this->cart->add($item->id, $qty);

        return redirect()->route('pos.index')->with('success', 'Ditambahkan ke keranjang.');
    }

    public function updateCart(UpdateCartItemRequest $request, Item $item): RedirectResponse
    {
        $qty = (int) $request->validated('qty');

        if ($qty === 0) {
            $this->cart->remove($item->id);

            return redirect()->route('pos.index')->with('success', 'Item dihapus dari keranjang.');
        }

        if (! isset($this->cart->getQuantities()[$item->id])) {
            return redirect()->route('pos.index');
        }

        if ($qty > $item->stock) {
            throw ValidationException::withMessages([
                "update_qty_{$item->id}" => "Stok tidak cukup (tersedia: {$item->stock}).",
            ]);
        }

        $this->cart->updateQuantity($item->id, $qty);

        return redirect()->route('pos.index')->with('success', 'Keranjang diperbarui.');
    }

    public function removeFromCart(Item $item): RedirectResponse
    {
        $this->cart->remove($item->id);

        return redirect()->route('pos.index')->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('pos.index')->with('error', 'Keranjang kosong.');
        }

        return view('pos.checkout', [
            'cartLines' => $this->cart->lines(),
            'cartTotal' => $this->cart->total(),
        ]);
    }

    public function processCheckout(CheckoutRequest $request): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('pos.index')->with('error', 'Keranjang kosong.');
        }

        $payTotal = (int) $request->validated('pay_total');
        $lines = $this->cart->lines();

        DB::transaction(function () use ($lines, $payTotal, $request) {
            $total = 0;
            $prepared = [];

            foreach ($lines as $line) {
                $item = Item::query()->lockForUpdate()->findOrFail($line->item->id);

                if ($item->stock < $line->qty) {
                    throw ValidationException::withMessages([
                        'pay_total' => "Stok tidak cukup untuk {$item->name} (tersedia: {$item->stock}).",
                    ]);
                }

                $subtotal = $item->price * $line->qty;
                $total += $subtotal;
                $prepared[] = [
                    'item' => $item,
                    'qty' => $line->qty,
                    'subtotal' => $subtotal,
                ];
            }

            $transaction = Transaction::query()->create([
                'user_id' => $request->user()->id,
                'date' => now(),
                'total' => $total,
                'pay_total' => $payTotal,
            ]);

            foreach ($prepared as $row) {
                TransactionDetail::query()->create([
                    'transaction_id' => $transaction->id,
                    'item_id' => $row['item']->id,
                    'qty' => $row['qty'],
                    'subtotal' => $row['subtotal'],
                ]);
                $row['item']->decrement('stock', $row['qty']);
            }
        });

        $this->cart->clear();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }
}
