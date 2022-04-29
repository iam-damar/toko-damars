@extends('layouts.master')

@section('title')
    Daftar Supplier
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Supplier</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('supplier.store') }}')" id="tambah-supplier" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('supplier.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function (){
        table = $('.table').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('supplier.data') }}',
            },
            columns: [
                // {data: 'select_all', searchable:false, sortable:false},
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'nama'},
                {data: 'telepon'},
                {data: 'alamat'},
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
                    alert('Tidak dapat menyimpan data supplier');
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
        $('#modal-form .modal-title').text('Tambah Supplier');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name = _method]').val('post')
        $('#modal-form [name = nama]').focus();
    };
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Supplier');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form form .btn-form').text('Update');
        $('#modal-form [name = _method]').val('put')
        $('#modal-form [name = nama]').focus();

        //menampilkan record nama 
        $.get(url)
            .done((response) => {
                // diisi nama
                $('#modal-form [name = nama]').val(response.nama);
                $('#modal-form [name = telepon]').val(response.telepon);
                $('#modal-form [name = alamat]').val(response.alamat);
            })
            .fail((response) => {
                alert("Tidak dapat menampilkan data supplier");
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
                    alert("Tidak dapat menghapus data supplier");
                    return;
                })
        }
    };
</script>
@endpush