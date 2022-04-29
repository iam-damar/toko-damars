@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir,false) }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="updatePeriode()" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-calendar"></i> Update Periode</button>
                    <a href="{{ route('laporan.export_pdf', [$tanggal_awal, $tanggal_akhir]) }}" target="_blank" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-file-pdf-o"></i>  Export PDF</a>
                    <a href="{{ route('laporan.export_excel', [$tanggal_awal, $tanggal_akhir]) }}" target="_blank" class="btn btn-success btn-xs btn-flat"><i class="fa fa-file-excel-o"></i>  Export Excel</a>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Penjualan</th> 
                            <th>Pembelian</th>
                            <th>Pengeluaran</th>
                            <th>Pendapatan</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('laporan.form')
@endsection

@push('scripts')
<script src="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    let table;

    $(function (){
        table = $('.table').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('laporan.data', [$tanggal_awal, $tanggal_akhir]) }}',
            },
            columns: [
                // {data: 'select_all', searchable:false, sortable:false},
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'tanggal'},
                {data: 'penjualan'},
                {data: 'pembelian'},
                {data: 'pengeluaran'},
                {data: 'pendapatan'}
            ],
            dom : 'Brt',
            bSort: false,
            bPaginate: false
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
    function updatePeriode() {
        $('#modal-form').modal('show');
    };
</script>
@endpush