<form id="scenarioForm" role="form" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="scenarioModalLabel">Cenários / #<?php echo $scenario->id; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="<?php echo $scenario->id; ?>">

        <ul class="nav nav-tabs mb-3" id="scenarioTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab">Dados</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="options-tab" data-bs-toggle="tab" data-bs-target="#options" type="button" role="tab">Opções de Respostas</button>
            </li>
        </ul>
           <div class="tab-content" id="scenarioTabContent">
               <div class="tab-pane fade show active" id="dados" role="tabpanel">
                   <div class="row">
                     <div class="col-md-12">
                         <div class="form-group">
                          <label for="title" class="control-label">Titulo</label>
                          <input type="text" class="form-control" name="title" id="title" maxlength="255"
                              value="<?php echo $scenario->title; ?>">
                          </div>
                      </div>

                    <div class="col-md-8">
                         <div class="form-group">
                         <label for="root_scenario_id" class="control-label">Raiz:</label>
                       <select name="root_scenario_id" class="form-control">
                          <option value="">Selecione</option>
                               <?php $__currentLoopData = $rootScenarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $root): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($root->id); ?>" <?php echo e($scenario->root_scenario_id == $root->id ? 'selected' : ''); ?>>
                             <?php echo e($root->title); ?>

                          </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                   </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                         <label for="idioma" class="control-label">Idioma:</label>
                            <select class="form-control" name="sigla" id="idioma" required>
                           <?php $__currentLoopData = $idiomas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idioma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($idioma->sigla); ?>"
                              <?php echo e(isset($scenario) && $scenario->sigla == $idioma->sigla ? 'selected' : ''); ?>>
                                 <?php echo e($idioma->sigla); ?>

                              </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                  <div class="col-md-2">
                <div class="form-group">
                    <label for="is_finally" class="control-label">Finalizado</label>
                     <select class="form-control" name="is_finally" id="is_finally" required>
                           <option value="0" <?php echo $scenario->is_finally == 0 ? ' selected ' : ''; ?>>Não</option>
                           <option value="1" <?php echo $scenario->is_finally == 1 ? ' selected ' : ''; ?>>Sim</option>
                     </select>
                </div>
                </div>
                <div class="col-lg-12">
                     <hr />
                   </div>
                     <div class="col-md-12">
                    <div class="form-group">
                    <label for="description" class="control-label">Texto: </label>
                    <textarea class="form-control ckeditor" name="description" id="description" rows="8"><?php echo $scenario->description; ?></textarea>
                     </div>
                  </div>
                   </div>
               </div>
               <div class="tab-pane fade" id="options" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                                  <button type="button" class="btn btn-primary mb-3 run-add-option-cadastro">
                                      <i class="fa fa-plus"></i> Adicionar opção
                                   </button>
                                   <div class="table-responsive">
                                 <table id="optionTable" class="table table-striped dataTable table-bordered" cellspacing="0"
                                    width="100%">
                                   <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Pontos</th>
                                        <th>Próximo</th>
                                        <th class="text-center">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                  </table>
                                  <br />
                                   </div>
                    </div>
               </div>
               </div>

            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i class="bi bi-door-closed"></i>
            Fechar
        </button>
        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Salvar</button>
        <button type="button" class="btn btn-danger run-btn-delete"><i class="bi bi-trash"></i> Excluir</button>
    </div>
</form>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\jogo_perguntas\admin\Modules/Scenario\Resources/views/edit.blade.php ENDPATH**/ ?>