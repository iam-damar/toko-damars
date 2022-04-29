<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('/AdminLTE-2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <title>Laporan Pendapatan (Excel)</title>
</head>
<body>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Penjualan</th> 
                <th>Pembelian</th>
                <th>Pengeluaran</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>
                            {{ $col }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
                <tr>
                    <td>
                        Tanggal {{ tanggal_indonesia($awal, false) }}
                        s/d 
                        Tanggal {{ tanggal_indonesia($akhir, false) }}
                    </td>
                </tr>
        </tbody>
    </table>
</body>
</html>