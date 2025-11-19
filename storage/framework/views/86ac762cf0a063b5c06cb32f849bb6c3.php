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
               <label for="date_expiracao" class="control-label">Data de expiração: </label>
               <input type="text" data-mask-type='datepicker' class="form-control" name="date_expiracao"
                  id="date_expiracao" value="<?php echo e($date_expiracao); ?>">
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
</form><?php /**PATH D:\work\www\bkp_2024\cuboo_group\mestre_dos_magos\mestre_dos_magos-web\Modules/Game\Resources/views/create.blade.php ENDPATH**/ ?>