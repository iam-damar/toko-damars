@extends('layouts.master')

@section('title')
    Daftar Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Kategori</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('kategori.store') }}')" id="tambah-kategori" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                        <thead>
                            <th width="5%">No</th>
                            <th>Kategori</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@includeIf('kategori.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function (){
        table = $('.table').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('kategori.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'nama_kategori'},
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
                    alert('Tidak dapat menyimpan data');
                    return;
                });
                // Model 2
                // $.ajax({
                //     url: $('#modal-form form').attr('action'),
                //     type: 'POST',
                //     data: $('#modal-form form').serialize()
                // })
                // .done((response) => {
                //     $('#modal-form').modal('hide');
                //     table.ajax.reload();
                // })
                // .fail((errors) => {
                //     alert('Tidak dapat menyimpan data');
                //     return;
                // });
            }
        });
    });
    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name = _method]').val('post')
        $('#modal-form [name = nama_kategori]').focus();
    };
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form form .btn-form').text('Update');
        $('#modal-form [name = _method]').val('put')
        $('#modal-form [name = nama_kategori]').focus();

        //menampilkan record nama 
        $.get(url)
            .done((response) => {
                // diisi nama
                $('#modal-form [name = nama_kategori]').val(response.nama_kategori);
            })
            .fail((response) => {
                alert("Tidak dapat menampilkan data");
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
                    alert("Tidak dapat menghapus data");
                    return;
                })
        }
    };
</script>
@endpush