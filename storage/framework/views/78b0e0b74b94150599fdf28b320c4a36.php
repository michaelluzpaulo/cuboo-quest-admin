<form id="optionForm" role="form" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="optionModalLabel">Option / #<?php echo $option->id; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="<?php echo $option->id; ?>">
        <input type="hidden" name="scenario_id" id="scenario_id" value="<?php echo e($scenario_id); ?>">
               <div class="row">
                     <div class="col-md-12">
                         <div class="form-group">
                          <label for="title" class="control-label">Titulo</label>
                          <input type="text" class="form-control" name="title" id="title" maxlength="255"
                              value="<?php echo $option->title; ?>">
                          </div>
                      </div>
                     <div class="col-md-2">
                        <div class="form-group">
                            <label for="points" class="control-label">Pontos</label>
                            <input type="number" class="form-control" name="points" id="points" value="<?php echo $option->points; ?>">
                        </div>
                    </div>
                    <div class="col-md-10">
                         <div class="form-group">
                         <label for="next_scenario_id" class="control-label">Próximo Cenário:</label>
                       <select name="next_scenario_id" class="form-control">
                               <?php $__currentLoopData = $nextScenarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $root): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($root->id); ?>" <?php echo e($option->next_scenario_id == $root->id ? 'selected' : ''); ?>>
                             <?php echo e($root->title); ?>

                          </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                       </div>
                    </div>
                    <div class="col-lg-12">
                     <hr />
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                             <label for="description" class="control-label">Texto: </label>
                             <textarea class="form-control ckeditor" name="description" id="description" rows="8">
                              <?php echo $option->description; ?></textarea>
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
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\jogo_perguntas\admin\Modules/Option\Resources/views/edit.blade.php ENDPATH**/ ?>