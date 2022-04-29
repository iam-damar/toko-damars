@extends('layouts.master')

@section('title')
    Daftar Member
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Member</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('member.store') }}')" id="tambah-kategori" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="cetakMember('{{ route('member.cetak_member') }}')" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-id-card"> Cetak member</i></button>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="POST" class="form-member"> 
                        @csrf
                        <table class="table table-striped table-bordered">
                            {{-- Pastikan jumnlah TH sesuai dengan columns datatable pada AJAX!!! --}}
                            <thead>
                                <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all"/>
                                </th>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@includeIf('member.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function (){
        table = $('.table').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('member.data') }}',
            },
            columns: [
                {data: 'select_all', searchable:false, sortable:false},
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'kode_member'},
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
                    alert('Tidak dapat menyimpan data member');
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
        $('[name=select_all]').on('click', function(){
            $(':checkbox').prop('checked', this.checked);
        });
    });
    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name = _method]').val('post')
        $('#modal-form [name = nama]').focus();
    };
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Member');

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
                alert("Tidak dapat menampilkan data member");
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
                    alert("Tidak dapat menghapus data member");
                    return;
                })
        }
    };
    function cetakMember(url){
        if($('input:checked').length < 1){
            alert('Pilih data untuk cetak member');
            return;
        }else {
            // Misalkan sudah 3 data terpilih
            $('.form-member')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush