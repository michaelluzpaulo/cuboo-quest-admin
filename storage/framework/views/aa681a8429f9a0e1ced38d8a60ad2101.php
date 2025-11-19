<form id="usuarioForm" role="form">
    <div class="modal-header">
        <h5 class="modal-title" id="usuarioModalLabel">Usuários / Novo cadastro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="control-label">Nome: </label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="control-label">E-mail: </label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" class="control-label">Senha: </label>
                    <input type="password" class="form-control" name="password" id="password" maxlength="12" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="confirm_password" class="control-label">Confirmação de Senha: </label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                        maxlength="12">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="role_id" class="control-label">Perfil: </label>
                    <select class="form-control" name="role_id" id="role_id" required>
                        <option value="">SELECIONE...</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($row['id']); ?>"><?php echo e($row['name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="active" class="control-label">Status: </label>
                    <select class="form-control" name="active" id="active">
                        <option value="1" selected="selected">ATIVO</option>
                        <option value="0">INATIVO</option>
                    </select>
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
<?php /**PATH /Volumes/work/www/cuboo_group/think_group/adm/Modules/Usuario/Resources/views/create.blade.php ENDPATH**/ ?>