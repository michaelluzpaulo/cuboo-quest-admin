<form id="minhaContaForm" role="form">
    <div class="modal-header">
        <h5 class="modal-title" id="minhaContaLabel">Minha Conta / <?php echo $usuario->name; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="<?php echo $usuario->id; ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="control-label active">Nome: </label>
                    <input type="text" class="form-control" name="name" id="name" required
                        value="<?php echo $usuario->name; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="control-label active">E-mail: </label>
                    <input type="email" class="form-control" name="email" id="email" required
                        value="<?php echo $usuario->email; ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" class="control-label">Senha: </label>
                    <input type="password" class="form-control" name="password" id="password" maxlength="12">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="confirm_password" class="control-label">Confirmação de Senha: </label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                        maxlength="12">
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
<?php /**PATH /Volumes/work/www/cuboo_group/think_group/adm/Modules/Usuario/Resources/views/profile.blade.php ENDPATH**/ ?>