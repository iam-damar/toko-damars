<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" class="form-horizontal">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-md col-offset-1 control-label">name</label>
                        <div class="col-md-6">
                            <input type="text" name="name" id="name" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-md col-offset-1 control-label">email</label>
                        <div class="col-md-6">
                            <input type="email" name="email" id="email" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-md col-offset-1 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control" minlength="5" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-4 col-md col-offset-1 control-label">Konfirmasi Password</label>
                        <div class="col-md-6">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required
                                data-match="#password"
                                >
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Batal</button>
                    <button class="btn btn-sm btn-flat btn-primary btn-form">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>