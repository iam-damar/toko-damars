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
                        <label for="deskripsi" class="col-md-2 col-md col-offset-1 control-label">Deskripsi</label>
                        <div class="col-md-6">
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" required autofocus/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal" class="col-md-2 col-md col-offset-1 control-label">Nominal</label>
                        <div class="col-md-6">
                            <input type="number" name="nominal" id="nominal" class="form-control" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Batal</button>
                    <button class="btn btn-sm btn-flat btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>