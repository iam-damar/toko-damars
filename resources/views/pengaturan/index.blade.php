@extends('layouts.master')

@section('title')
    Pengaturan Toko
@endsection

@section('breadcrumb')
    @parent
    <li class="active">
        Pengaturan Toko
    </li>
@endsection

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                {{-- enctype digunakan untuk menambahkan upload gambar di form --}}
                <form action="{{ route('setting.update') }}" method="POST" class="form-pengaturan" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="box-body">
                        <div class="alert alert-success alert-dismissible" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-check"></i> Pengaturan berhasil diupdate
                        </div>
                        <div class="form-group row" style="margin-top: 4rem;">
                            <label for="nama_perusahaan" class="col-md-2 col-md-offset-1 label-control">Nama Perusahaan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required autofocus>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telepon" class="col-md-2 col-md-offset-1 label-control">Nomor Telepon</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="telepon" name="telepon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-2 col-md-offset-1 label-control">Alamat</label>
                            <div class="col-md-6">
                                <textarea name="alamat" class="form-control" id="alamat" rows="4" required></textarea>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_logo" class="col-md-2 col-md-offset-1 label-control">Logo Perusahaan</label>
                            <div class="col-md-3">
                                <input type="file" class="form-control" id="path_logo" name="path_logo"
                                    onchange="preview('.tampil-logo', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <div class="mt-2"></div>
                                <div class="tampil-logo"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_kartu_member" class="col-md-2 col-md-offset-1 label-control">Kartu Member</label>
                            <div class="col-md-3">
                                <input type="file" class="form-control" id="path_kartu_member" name="path_kartu_member"
                                    onchange="preview('.tampil-kartu-member', this.files[0], 300)">
                                <span class="help-block with-errors"></span>
                                <div class="mt-2"></div>
                                <div class="tampil-kartu-member"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diskon" class="col-md-2 col-md-offset-1 label-control">Diskon Member</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" id="diskon" name="diskon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tipe_nota" class="col-md-2 col-md-offset-1 label-control">Tipe Nota</label>
                            <div class="col-md-3">
                                <select class="form-control" id="tipe_nota" name="tipe_nota" required>
                                    <option value="1">Nota Kecil</option>
                                    <option value="2">Nota Besar</option>
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-sm btn-flat btn-primary btn-form pull-right ">Update Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            showData();
            $('.form-pengaturan').validator().on('submit', function(e) {
                if(! e.preventDefault()){
                    $.ajax({
                        url: $('.form-pengaturan').attr('action'),
                        type: $('.form-pengaturan').attr('method'),
                        data: new FormData($('.form-pengaturan')[0]),
                        async: false,
                        processData: false,
                        contentType: false
                    })
                    .done(responses => {
                        showData();
                        $('.alert').fadeIn();

                        setTimeout(() => {
                            $('.alert').fadeOut();
                        }, 3000);
                    })
                    .fail( errors => {
                        alert('Tidak dapat mengupdate pengaturan'); return;
                    }); 
                }
            });
        });

        function showData(){
            $.get('{{ route('setting.show') }}')
                .done(responses =>{
                    
                    $('[name=nama_perusahaan]').val(responses.nama_perusahaan);
                    $('[name=telepon]').val(responses.telepon);
                    $('[name=alamat]').val(responses.alamat);
                    $('[name=diskon]').val(responses.diskon);
                    $('[name=tipe_nota]').val(responses.tipe_nota);
                    $('title').text(responses.nama_perusahaan + ' | Pengaturan Toko');
                    $('.logo-lg').text(responses.nama_perusahaan);

                    let pecah_kata = responses.nama_perusahaan.split(' ');
                    let ambil_huruf = '';
                    pecah_kata.forEach(ahf => {
                        ambil_huruf += ahf.charAt(0);
                    });
                    $('.logo-mini').text(ambil_huruf);

                    $('.tampil-logo').html(`<img src="{{ url('/') }}${responses.path_logo}" width="100">`);
                    $('.tampil-kartu-member').html(`<img src="{{ url('/') }}${responses.path_kartu_member}" width="300">`);

                    $('[rel=icon]').attr('href', `{{ url('/') }}/${responses.path_logo}`);
                })
                .fail(errors => {
                    
                    alert('Tidak dapat menampilkan Data'); return;
                });
        };
    </script>
@endpush