<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'pos_cart';

    /**
     * @return array<int, int> item_id => qty
     */
    public function getQuantities(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function add(int $itemId, int $qty): void
    {
        $quantities = $this->getQuantities();
        $quantities[$itemId] = ($quantities[$itemId] ?? 0) + $qty;
        Session::put(self::SESSION_KEY, $quantities);
    }

    public function updateQuantity(int $itemId, int $qty): void
    {
        $quantities = $this->getQuantities();
        if ($qty <= 0) {
            unset($quantities[$itemId]);
        } else {
            $quantities[$itemId] = $qty;
        }
        Session::put(self::SESSION_KEY, $quantities);
    }

    public function remove(int $itemId): void
    {
        $quantities = $this->getQuantities();
        unset($quantities[$itemId]);
        Session::put(self::SESSION_KEY, $quantities);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * @return Collection<int, object{ item: Item, qty: int, subtotal: int }>
     */
    public function lines(): Collection
    {
        $quantities = $this->getQuantities();
        if ($quantities === []) {
            return collect();
        }

        $items = Item::query()
            ->whereIn('id', array_keys($quantities))
            ->get()
            ->keyBy('id');

        return collect($quantities)
            ->map(function (int $qty, int $itemId) use ($items) {
                $item = $items->get($itemId);
                if (! $item) {
                    return null;
                }

                return (object) [
                    'item' => $item,
                    'qty' => $qty,
                    'subtotal' => $item->price * $qty,
                ];
            })
            ->filter()
            ->values();
    }

    public function total(): int
    {
        return (int) $this->lines()->sum('subtotal');
    }

    public function isEmpty(): bool
    {
        return $this->getQuantities() === [];
    }
}
