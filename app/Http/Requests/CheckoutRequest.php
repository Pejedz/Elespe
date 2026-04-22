<?php

namespace App\Http\Requests;

use App\Services\CartService;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $total = app(CartService::class)->total();

        return [
            'pay_total' => ['required', 'integer', 'min:'.$total],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            if (app(CartService::class)->isEmpty()) {
                $validator->errors()->add('pay_total', 'Keranjang kosong.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'pay_total.min' => 'Jumlah pembayaran harus sama atau lebih besar dari total.',
        ];
    }
}
