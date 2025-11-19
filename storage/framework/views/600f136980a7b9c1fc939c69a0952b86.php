<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(asset('vendorjs/ckeditor4/ckeditor.js')); ?>?v=2"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendorjs/ckeditor4/adapters/jquery.js')); ?>"></script>
    <script type="text/javascript" src="/dist/js/modules/Scenario.js?v=2"></script>
    <script type="text/javascript" src="/dist/js/modules/ScenarioOption.js?v=2"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            Scenario.init();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('module_title'); ?>
    <h1><small>Cadastros /</small> Cenários</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="card card-secondary card-outline">
            <div class="card-header">

                <form name="form-scenario-principal" id="form-scenario-principal">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="filtro_id" class="control-label">Registro ID</label>
                                <input type="number" class="form-control" name="filtro_id" id="filtro_id" autofocus="">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="filtro_title" class="control-label">Título</label>
                                <input type="text" class="form-control" name="filtro_title" id="filtro_title"
                                    placeholder="Digite uma palavra chave">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="control-label" for="filtro_scenarios">Cenário Raiz</label>
                                <select class="form-control" name="filtro_scenarios" id="filtro_scenarios" style="width:100%">
                                    <option value="" disabled selected>Todos</option>
                                    <?php $__currentLoopData = $scenarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($s->id); ?>"><?php echo e($s->title); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-1">
                            <label class="control-label">&nbsp;</label>
                            <button type="submit" class="run-search btn btn-secondary btn-block" data-toggle="tooltip"
                                data-placement="top" title="" id="btn-refresh"
                                data-original-title="Carregar resultados"><i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="col-lg-1">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" class="btn  btn-secondary btn-block run-add-cadastro"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Adicionar um cadastro"><i class="fa fa-plus"></i>
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
                            <table id="scenarioTable" class="table table-striped dataTable table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th class="text-center">Tela Raiz</th>
                                        <th class="text-center">Tela Final</th>
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

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\www\bkp_2024\cuboo_group\jogo_perguntas\admin\Modules/Scenario\Resources/views/index.blade.php ENDPATH**/ ?>