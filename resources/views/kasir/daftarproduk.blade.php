@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border" style="margin-top: 15px;">
                    <h1 class="box-title" style="font-size: 24px;"><b>Daftar Produk Toko </b></h1>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-kasir-produk">
                        {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Harga Jual</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let table_kasir_produk;

    $(function() {
        table_kasir_produk = $('.table-kasir-produk').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('kasir.data_produk') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'stok'},
            ]
        });
    });

</script>
@endpush