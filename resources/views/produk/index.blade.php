@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="btn-group">
                        <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                        <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                        <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    {{-- Form dogunakan untuk mengambil data yang terpilih berdasarkan checkbox untuk dilakukan delete selected --}}
                    <form action="" method="POST" class="form-produk"> 
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
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stok</th>
                                <th width="15%"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@includeIf('produk.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function (){
        table = $('.table').DataTable({
            processing: true,
            autowidth: false,
            ajax : {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all'},
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'stok'},
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

        $('[name=select_all]').on('click', function(){
            $(':checkbox').prop('checked', this.checked);
        });
    });
    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name = _method]').val('post')
        $('#modal-form [name = nama_produk]').focus();
    };
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form form .btn-form').text('Update');
        $('#modal-form [name = _method]').val('put')
        $('#modal-form [name = nama_produk]').focus();

        //menampilkan record nama 
        $.get(url)
            .done((response) => {
                // diisi nama
                $('#modal-form [name = nama_produk]').val(response.nama_produk);
                // $('#modal-form [name = kode_produk]').val(response.kode_produk);
                $('#modal-form [name = id_kategori]').val(response.id_kategori);
                $('#modal-form [name = merk]').val(response.merk);
                $('#modal-form [name = harga_beli]').val(response.harga_beli);
                $('#modal-form [name = harga_jual]').val(response.harga_jual);
                $('#modal-form [name = diskon]').val(response.diskon);
                $('#modal-form [name = stok]').val(response.stok);
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
    // Menggunakan URL
    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, $('.form-produk').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((response) => {
                        alert("Tidak dapat menghapus data");
                        return;
                    });
            }
        } else {
            // jika tidak ada yang tercheck list
            alert('Pilih data yang akan dihapus');
            return;
        }
    };
    function cetakBarcode(url){

        if($('input:checked').length < 1){
            alert('Pilih data untuk cetak barcode');
            return;
        }else if($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk cetak barcode');
            return;
        } else {
            // Misalkan sudah 3 data terpilih
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    };
    // };
    // Tanpa URL
    // function deleteSelected() {
    //     if ($('input:checked').length > 1) {
            
    //     } else {
    //         // jika tidak ada yang tercheck list
    //         alert('Pilih data yang akan dihapus');
    //         return;
    //     }
    // };
</script>
@endpush