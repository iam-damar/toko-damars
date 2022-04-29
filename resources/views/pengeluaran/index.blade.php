@extends('layouts.master')

@section('title')
    Daftar Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengeluaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('pengeluaran.store') }}')" id="tambah-pengeluaran" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th> {{-- Jenis Pengeluaran --}}
                            <th>Nominal</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('pengeluaran.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function (){
        table = $('.table').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('pengeluaran.data') }}',
            },
            columns: [
                // {data: 'select_all', searchable:false, sortable:false},
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'created_at'},
                {data: 'deskripsi'},
                {data: 'nominal'},
                {data: 'aksi', searchable:false, sortable:false},
            ]
        });
        $('#modal-form').validator().on('submit', function(e){
            if (! e.preventDefault()) {
                // Model 1
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menyimpan data Pengeluaran');
                    return;
                });
            }
        });
        // fitur checkbox
        // $('[name=select_all]').on('click', function(){
        //     $(':checkbox').prop('checked', this.checked);
        // });
    });
    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name = _method]').val('post')
        $('#modal-form [name = deskripsi]').focus();
    };
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name = _method]').val('put')
        $('#modal-form [name = deskripsi]').focus();

        //menampilkan record nama 
        $.get(url)
            .done((response) => {
                // diisi nama
                $('#modal-form [name = deskripsi]').val(response.deskripsi);
                $('#modal-form [name = nominal]').val(response.nominal);
            })
            .fail((response) => {
                alert("Tidak dapat menampilkan data pengeluaran");
                return;
            });

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
                    alert("Tidak dapat menghapus data pengeluaran");
                    return;
                })
        }
    };
</script>
@endpush