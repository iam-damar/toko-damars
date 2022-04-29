@extends('layouts.master')

@section('title')
    Daftar Riwayat Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Riwayat Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border" style="margin-top: 15px;">
                    <h1 class="box-title" style="font-size: 24px;"><b>Riwayat Transaksi </b></h1>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-kasir-penjualan">
                        {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th width="12%">Kode Member</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon Member</th>
                            <th>Total Bayar</th>
                            <th>Kasir</th>
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
    let table_kasir_riwayat_transaksi_penjualan;

    $(function() {
        table_kasir_riwayat_transaksi_penjualan = $('.table-kasir-penjualan').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('kasir.data_penjualan') }}',
            },
            columns: [
                // Isi data harus sesuai dengan database!.
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'tanggal'},
                {data: 'jam'},
                {data: 'kode_member'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'kasir'},
            ]
        });
    });

</script>
@endpush