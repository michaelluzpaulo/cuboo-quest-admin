<form id="gameForm" role="form">
    <div class="modal-header">
        <h5 class="modal-title" id="gameModalLabel">Game / Novo cadastro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="control-label">Nome da Game: </label>
                    <input type="text" class="form-control" name="nome" id="nome" maxlength="70">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tema_id" class="control-label">Tema: </label>
                    <select class="form-control" name="tema_id" id="tema_id">
                        <option value="">Selecione...</option>
                        <?php $__currentLoopData = $temas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t->id); ?>"><?php echo e($t->titulo); ?> (<?php echo e($t->idioma); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="scenario_id" class="control-label">Scenario Raiz: </label>
                    <select class="form-control" name="scenario_id" id="scenario_id">
                        <option value="">Selecione...</option>
                        <?php $__currentLoopData = $scenario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t->id); ?>"><?php echo e($t->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="active_ranking" class="control-label">Final com Ranking: </label>
                    <select class="form-control" name="active_ranking" id="active_ranking">
                        <option value="S" selected="selected">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="active_ranking_unit" class="control-label">Ranking Unitário:</label>
                    <select class="form-control" name="active_ranking_unit" id="active_ranking_unit">
                        <option value="N" selected="selected">Não</option>
                        <option value="S">Sim</option>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_expiracao" class="control-label">Data de expiração: </label>
                    <input type="text" data-mask-type='datepicker' class="form-control" name="date_expiracao"
                        id="date_expiracao" value="<?php echo e($date_expiracao); ?>">
                </div>
            </div>
            <div class="col-lg-12">
                <hr />
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="agrupador_id" class="control-label">Agrupador:</label>
                    <select class="form-select" name="agrupador_id" id="agrupador_id">
                        <option value="">Nenhum agrupador</option>
                        <?php $__currentLoopData = $agrupadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agrupador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($agrupador->id); ?>"><?php echo e($agrupador->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="novo_agrupador" class="control-label">Criar novo agrupador:</label>
                    <input type="text" class="form-control" id="novo_agrupador" name="novo_agrupador"
                        placeholder="Digite para criar">
                    <small class="text-muted">Se preencher este campo, ignora o select acima.</small>
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
<?php /**PATH C:\www\cuboo_group\quest_group\cuboo-quest-admin\Modules/Game\Resources/views/create.blade.php ENDPATH**/ ?>