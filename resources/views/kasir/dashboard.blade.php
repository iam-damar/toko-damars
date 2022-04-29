@extends('layouts.master')

@section('title')
    Dashboard Kasir
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard Kasir</li>
@endsection

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $jumlah_penjualan }}</h3>

                    <p>Total Riwayat Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-history"></i>
                </div>
                <a href="{{ route('kasir.penjualan') }}" target="_blank" class="small-box-footer">Lihat Lebih <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $produk }}</h3>

                    <p>Total Produk</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <a href="{{ route('kasir.daftar_produk') }}" target="_blank" class="small-box-footer">Lihat Lebih <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body text-center">
                    <div class="text-left d-flex">
                        <p>Today: <b>{{ tanggal_indonesia($waktu_sekarang) }}</b></p>
                        <p>Time: <b>{{ $waktu_sekarang->format('H:i:s') }}</b></p>
                    </div>
                    <h2>Selamat Datang</h2>
                    <h3>Anda login sebagai <b>KASIR</b></h3>
                    <br>
                    <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg">Transaksi Baru</a>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row (main row) -->
@endsection