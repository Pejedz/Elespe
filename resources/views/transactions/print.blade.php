<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            margin: 0;
            padding: 16px;
            background: #ffffff;
            color: #111827;
        }
        .receipt {
            max-width: 360px;
            margin: 0 auto;
            font-size: 13px;
            line-height: 1.45;
        }
        .center {
            text-align: center;
        }
        .separator {
            border-top: 1px dashed #6b7280;
            margin: 10px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }
        .muted {
            color: #4b5563;
        }
        .item {
            margin-bottom: 6px;
        }
        .totals .row {
            margin-bottom: 4px;
        }
        .strong {
            font-weight: 700;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt {
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="center">
            <div class="strong">TOKO POS</div>
            <div class="muted">Struk Pembelian</div>
        </div>

        <div class="separator"></div>

        <div class="row">
            <span>No. Transaksi</span>
            <span>#{{ $transaction->id }}</span>
        </div>
        <div class="row">
            <span>Tanggal</span>
            <span>{{ $transaction->date->format('d/m/Y H:i:s') }}</span>
        </div>
        <div class="row">
            <span>Kasir</span>
            <span>{{ $transaction->user->name }}</span>
        </div>

        <div class="separator"></div>

        @foreach ($transaction->details as $detail)
            <div class="item">
                <div>{{ $detail->item->name }}</div>
                <div class="row muted">
                    <span>{{ $detail->qty }} x Rp {{ number_format((int) ($detail->subtotal / max(1, $detail->qty)), 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <div class="separator"></div>

        <div class="totals">
            <div class="row">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Bayar</span>
                <span>Rp {{ number_format($transaction->pay_total, 0, ',', '.') }}</span>
            </div>
            <div class="row strong">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="center muted">
            Terima kasih telah berbelanja.
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>
