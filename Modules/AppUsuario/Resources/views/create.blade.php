<form id="usuarioForm" role="form">
    <div class="modal-header">
        <h5 class="modal-title" id="usuarioModalLabel">Usuários do APP / Novo cadastro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="control-label">Nome: </label>
                    <input type="text" class="form-control" name="nome" id="nome" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="control-label">E-mail: </label>
                    <input type="text" class="form-control" name="email" id="email" required>
                </div>
            </div>
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i class="bi bi-door-closed"></i>
            Fechar
        </button>
        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Salvar</button>
    </div>
</form>
