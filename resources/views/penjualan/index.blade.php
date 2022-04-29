@extends('layouts.master')

@section('title')
    Daftar Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Penjualan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-penjualan">
                        {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th width="12%">Kode Member</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon Member</th>
                            <th>Total Bayar</th>
                            <th>Kasir</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('penjualan.detail')
@endsection

@push('scripts')
<script>
    let table, tableprodukdetail;

    $(function (){
        table = $('.table-penjualan').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('penjualan.data') }}',
            },
            columns: [
                // Isi data harus sesuai dengan database!.
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'tanggal'},
                {data: 'kode_member'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'kasir'},
                {data: 'aksi', searchable:false, sortable:false},
            ]
        });

        tableprodukdetail = $('.table-detail').DataTable({
            processing: true,
            bsort: false,
            dom: 'Brt',
            columns: [
                // Isi data harus sesuai dengan database!.
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        });
    });

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