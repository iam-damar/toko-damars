@extends('layouts.master')

@section('title')
    Daftar Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pembelian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
                    @empty(! session('id_pembelian'))
                        <a type="button" href="{{ route('pembelian_detail.index') }}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-pencil"></i> Transaksi Aktif</a>
                    @endempty
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-pembelian">
                        {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts')
<script>
    let table, tableprodukdetail;

    $(function (){
        table = $('.table-pembelian').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('pembelian.data') }}',
            },
            columns: [
                // Isi data harus sesuai dengan database!.
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'tanggal'},
                {data: 'supplier'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'aksi', searchable:false, sortable:false},
            ]
        });
        $('.table-supplier').DataTable();

        tableprodukdetail = $('.table-detail').DataTable({
            processing: true,
            bsort: false,
            dom: 'Brt',
            columns: [
                // Isi data harus sesuai dengan database!.
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        });
    });
    function addForm() {
        $('#modal-supplier').modal('show');

    };
    function showDetail(url){
        $('#modal-detail').modal('show');

        tableprodukdetail.ajax.url(url);
        tableprodukdetail.ajax.reload();
    };
    function deleteData(url) {
        if (confirm("Ingin menghapus Data terpilih?")) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
            })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert("Tidak dapat menghapus data supplier");
                    return;
                })
        }
    };
</script>
@endpush