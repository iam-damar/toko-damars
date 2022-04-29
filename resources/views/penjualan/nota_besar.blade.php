<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Besar PDF</title>

    <style>
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        table td{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }
        table.data th,
        table.data td{
            padding: 5px;
            border: 1px solid #ccc;
        }
        table.data {
            border-collapse: collapse;
        }

    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td rowspan="3" width="60%">
                <img src="{{ public_path($setting->path_logo) }}" alt="{{ $setting->path_logo }}" width="60">
                <br>
                <br>
                {{ ucwords($setting->nama_perusahaan) }}
                <br>
                {{ $setting->alamat }}
                <br>
                <br>
            </td>
            <td>Tanggal</td>
            <td>: {{ tanggal_indonesia(date('Y-m=d')) }}</td>
        </tr>
        <tr>
            <td>Kode Member</td>
            <td>: {{ $penjualan->member->kode_member ?? '' }}</td>
        </tr>
    </table>
    <table class="data" width="100%">
        <thead>
            <tr>
                <td>No</td>
                <td>Kode Produk</td>
                <td>Nama Produk</td>
                <td>Harga Satuan</td>
                <td>Jumlah</td>
                <td>Diskon Produk</td>
                <td>Subtotal</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $key => $item)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{ $item->produk->kode_produk }}</td>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td class="text-right">{{ format_uang($item->harga_jual) }}</td>
                    <td class="text-right">{{ format_uang($item->jumlah) }}</td>
                    <td class="text-right">{{ $item->diskon }} %</td>
                    <td class="text-right">{{ format_uang($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">Total Harga</td>
                <td class="text-right"><b>{{ format_uang($penjualan->total_harga) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-right">Diskon Member</td>
                <td class="text-right"><b>{{ format_uang($penjualan->diskon) }}</b> %</td>
            </tr>
            <tr>
                <td colspan="6" class="text-right">Total Bayar</td>
                <td class="text-right"><b>{{ format_uang($penjualan->bayar) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-right">Diterima</td>
                <td class="text-right"><b>{{ format_uang($penjualan->diterima) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" class="text-right">Kembali</td>
                <td class="text-right"><b>{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</b></td>
            </tr>
        </tfoot>
    </table>

    <table width="100%">
        <br>
        <br>
        <tr>
            <td><b>Terimakasih Telah berbelanja ditoko Kami, Sampai Jumpa Kembali</b></td>
            <td class="text-center">
                Kasir
                <br>
                <br>
                {{ auth()->user()->name }}
                
            </td>
        </tr>
    </table>
</body>
</html>