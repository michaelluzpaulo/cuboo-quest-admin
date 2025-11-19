<form id="scenarioForm" role="form">
    <div class="modal-header">
        <h5 class="modal-title" id="scenarioModalLabel">Cenários / Novo cadastro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="0">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="title" class="control-label">Titulo</label>
                    <input type="text" class="form-control" name="title" id="title" maxlength="255">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                  <label for="root_scenario_id" class="control-label">Raiz:</label>
<select name="root_scenario_id" class="form-control">
    <option value="">Selecione</option>
    <?php $__currentLoopData = $rootScenarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $root): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($root->id); ?>"><?php echo e($root->title); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
                </div>
            </div>
           <div class="col-lg-2">
                <div class="form-group">
                    <label for="sigla" class="control-label">Idioma: </label>
                    <select name="sigla" class="form-control">
    <?php $__currentLoopData = $idiomas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idioma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($idioma); ?>"><?php echo e($idioma); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
                </div>
            </div>

             <div class="col-md-2">
                <div class="form-group">
                    <label for="is_finally" class="control-label">Finalizado</label>
                     <select class="form-control" name="is_finally" id="is_finally" required>
                           <option value="0">Não</option>
                           <option value="1">Sim</option>
                     </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description" class="control-label">Texto </label>
                    <textarea class="form-control ckeditor" name="description" id="description" rows="8"></textarea>
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
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\jogo_perguntas\admin\Modules/Scenario\Resources/views/create.blade.php ENDPATH**/ ?>