@extends('layouts.master')

@section('title')
    Edit Profil
@endsection

@section('breadcrumb')
    @parent
    <li class="active">
        Edit Profil
    </li>
@endsection

@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                {{-- enctype digunakan untuk menambahkan upload gambar di form --}}
                <form action="{{ route('user.update_profil') }}" method="POST" class="form-profil" enctype="multipart/form-data" data-toggle="validator">
                    @csrf
                    <div class="box-body">
                        <div class="alert alert-success alert-dismissible" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-check"></i> Pengaturan berhasil diupdate
                        </div>
                        <div class="form-group row" style="margin-top: 4rem;">
                            <label for="name" class="col-md-2 col-md-offset-1 label-control">Nama</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="{{ $profil->name }}">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="foto" class="col-md-2 col-md-offset-1 label-control">Foto Profil</label>
                            <div class="col-md-3">
                                <input type="file" class="form-control" id="foto" name="foto"
                                    onchange="preview('.tampil-foto', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <div class="mt-2"></div>
                                <div class="tampil-foto"><img src="{{ url($profil->foto ?? '/') }}" width="100"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_lama" class="col-md-2 col-md-offset-1 control-label">Password Lama</label>
                            <div class="col-md-4">
                                <input type="password" name="password_lama" id="password_lama" class="form-control" minlength="5">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-md-offset-1 control-label">Password</label>
                            <div class="col-md-4">
                                <input type="password" name="password" id="password" class="form-control" minlength="5">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-2 col-md-offset-1 control-label">Konfirmasi Password</label>
                            <div class="col-md-4">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                    data-match="#password"
                                    >
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
            $('#password_lama').on('keyup', function () {
                if($(this).val() != ""){
                    $('#password, #password_confirmation').attr('required', true);
                } else {
                    $('#password, #password_confirmation').attr('required', false);
                }
            });
            $('.form-profil').validator().on('submit', function(e) {
                if(! e.preventDefault()){
                    $.ajax({
                        url: $('.form-profil').attr('action'),
                        type: $('.form-profil').attr('method'),
                        data: new FormData($('.form-profil')[0]),
                        async: false,
                        processData: false,
                        contentType: false
                    })
                    .done(responses => {
                        $('[name=name]').val(responses.name);
                        $('.tampil-foto').html(`<img src="{{ url('/') }}${responses.foto}" width="50">`)
                        $('.image-profil').attr('src', `{{ url('/') }}/${responses.foto}`)
                        $('.alert').fadeIn();

                        setTimeout(() => {
                            $('.alert').fadeOut();
                        }, 3000);
                    })
                    .fail( errors => {
                        if (errors.status == 422) {
                            
                            alert(errors.responseJSON);
                        } else {
                            
                            alert('Tidak dapat mengupdate pengaturan');
                        }
                        return;
                    }); 
                }
            });
        });
    </script>
@endpush