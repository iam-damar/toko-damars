@extends('layouts.master')

@section('title')
    Pengaturan User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengaturan User</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Kasir Toko</th>
                            <th>Email</th> 
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('user.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function (){
        table = $('.table').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('user.data') }}',
            },
            columns: [
                // {data: 'select_all', searchable:false, sortable:false},
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'name'},
                {data: 'email'},
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
                    alert('Tidak dapat menyimpan data user');
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
        $('#modal-form .modal-title').text('Tambah User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name = _method]').val('post')
        $('#modal-form [name = name]').focus();

        $('#password, #password_confirmation').attr('required', true);
    };
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form form .btn-form').text('Update');
        $('#modal-form [name = _method]').val('put')
        $('#modal-form [name = name]').focus();
        $('#password, #password_confirmation').attr('required', false);

        //menampilkan record nama 
        $.get(url)
            .done((response) => {
                // diisi nama
                $('#modal-form [name = name]').val(response.name);
                $('#modal-form [name = email]').val(response.email);
            })
            .fail((response) => {
                alert("Tidak dapat menampilkan data user");
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
                    alert("Tidak dapat menghapus data user");
                    return;
                })
        }
    };
</script>
@endpush