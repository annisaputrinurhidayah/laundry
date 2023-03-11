<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .invoice {
            width: 70mm;
        }

        .logo {
            width: 80px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
        }

        table {
            width: 100%;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        hr {
            border: 1px solid #8c8b8b;
        }
    </style>
</head>

<body>

    <body onload="javascript:window.print()">
        <div class="invoice">
            <img src="/images/logo.png" alt="" class="logo">
            <h3 class="center">{{ $outlet->nama }}</h3>

            <p class="center">
                {{ $outlet->alamat }} <br> {{ $outlet->tlp }}
            </p>
            <hr>
            <p>
                Kode Transaksi : {{ $transaksi->kode_invoice }} <br>
                Tanggal Transaksi : {{ date('d/m/Y H:i:s', strtotime($transaksi->tgl)) }} <br>
                Batas waktu diambil/diantar : {{ date('d/m/Y', strtotime($transaksi->batas_waktu)) }} <br>
                @if ($transaksi->dibayar == 'dibayar')
                    Tanggal Bayar : {{ date('d/m/Y H:i:s', strtotime($transaksi->tgl_bayar)) }} <br>
                @endif
                Tanggal Selesai : {{ date('d/m/Y H:i:s', strtotime($transaksi->tgl_selesai)) }} <br>
                @if ($transaksi->status == 'diambil')
                    Diambil : {{ date('d/m/Y H:i:s', strtotime($transaksi->tgl_diambil)) }} <br>
                @endif
                Nama Pelanggan : {{ $member->nama }} <br>
                Kasir : {{ $user->nama }}
            </p>
            <hr>

            <table>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            {{ $item->qty }} {{ $item->nama_paket }} x {{ number_format($item->harga, 0, ',', '.') }} <br>
                            @if ($item->discount_type == 'percent')
                                    ({{ number_format($item->qty * $item->diskon, 0, ',', '.') }}%)
                                            @elseif($item->discount_type == 'fixed')
                                            ({{ number_format($item->qty * $item->diskon, 0, ',', '.') }})
                                            @else
                                        @endif
                            <small>Ket : {{ $item->keterangan }}</small>
                        </td>
                        <td class="right">
                            @if ($item->diskon_paket != null)
                            <del>{{ number_format($item->harga * $item->qty,0,',','.') }}</del>
                            {{ number_format($item->sub_total,0,',','.') }}
                            @else
                            {{ number_format($item->sub_total,0,',','.') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            <hr>
            <p class="right">
                Sub Total : {{ number_format($transaksi->sub_total, 0, ',', '.') }} <br>
                Diskon Tambahan: {{ number_format($transaksi->diskon, 0, ',', '.') }} <br>
                Biaya Tambahan : {{ number_format($transaksi->biaya_tambahan, 0, ',', '.') }} <br>
                Pajak PPN(10%) : {{ number_format($transaksi->pajak, 0, ',', '.') }} <br>
                Total : {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                @if ($transaksi->bayar == 'bayar')
                    <br>
                    Tunai : {{ number_format($transaksi->cash, 0, ',', '.') }}
                    Kembalian : {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                @endif

                @if ($transaksi->dibayar == 'dibayar')
                    <h3 class="center">Terima Kasih</h3>
                @endif
            </p>
            <p class="right">
                @if ($transaksi->tgl_diambil == null)
                    <small>
                        <i>
                        </i>
                    </small>
                @else
                    <small>
                        <i>
                            Diambil: {{ date('d-M-Y', strtotime($transaksi->tgl_diambil)) }}
                        </i>
                    </small>
                @endif
            </p>
        </div>
    </body>

</html>
