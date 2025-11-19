

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript" src="<?php echo e(asset('vendorjs/ckeditor4/ckeditor.js')); ?>?v=3"></script>
<script type="text/javascript" src="<?php echo e(asset('vendorjs/ckeditor4/adapters/jquery.js')); ?>"></script>
<script type="text/javascript" src="/dist/js/modules/Game.js?v=<?php echo time(); ?>"></script>
<script type="text/javascript">
   $(document).ready(function() {
            Game.init();
        });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('module_title'); ?>
<h1><small>Cadastros /</small> Games</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="content">
   <div class="card card-secondary card-outline">
      <div class="card-header">

         <form name="form-game-principal" id="form-game-principal">
            <div class="row">
               <div class="col-lg-2">
                  <div class="form-group">
                     <label for="filtro_id" class="control-label">Registro ID</label>
                     <input type="number" class="form-control" name="filtro_id" id="filtro_id" autofocus="">
                  </div>
               </div>

               <div class="col-lg-3">
                  <div class="form-group">
                     <label for="filtro_nome" class="control-label">Nome</label>
                     <input type="text" class="form-control" name="filtro_nome" id="filtro_nome"
                        placeholder="Digite uma palavra chave">
                  </div>
               </div>

               <div class="col-lg-1">
                  <label class="control-label">&nbsp;</label>
                  <button type="submit" class="run-search btn btn-secondary btn-block" data-toggle="tooltip"
                     data-placement="top" title="" id="btn-refresh" data-original-title="Carregar resultados"><i
                        class="fa fa-search"></i>
                  </button>
               </div>
               <div class="col-lg-1">
                  <label class="control-label">&nbsp;</label>
                  <button type="button" class="btn  btn-secondary btn-block run-add-cadastro" data-toggle="tooltip"
                     data-placement="top" title="" data-original-title="Adicionar um cadastro"><i
                        class="fa fa-plus"></i>
                  </button>
               </div>
            </div>
         </form>
      </div>

      <div class="card-body pb-4">
         <div class="row">
            <div class="col-12">
               <br />
               <div class="table-responsive">
                  <table id="gameTable" class="table table-striped dataTable table-bordered" cellspacing="0"
                     width="100%">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>nome</th>
                           <th>Tema</th>
                           <th>Idioma</th>
                           <th>Status</th>
                           <th>Game Link</th>
                           <th>GM</th>
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
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\www\bkp_2024\cuboo_group\quest_group\admin\Modules/Game\Resources/views/index.blade.php ENDPATH**/ ?>