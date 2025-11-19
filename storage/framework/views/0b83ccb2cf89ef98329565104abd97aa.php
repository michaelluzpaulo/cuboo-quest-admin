

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="/dist/js/modules/Usuario.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            Usuario.init();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('module_title'); ?>
    <h1><small>Cadastros /</small> Usuários</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="card card-secondary card-outline">
            <div class="card-header">
                <form name="form-usuario-principal" id="form-usuario-principal">
                    <div class="row">
                        <div class="col-1">
                            <div class="form-group">
                                <label for="filtro_id" class="control-label">#ID</label>
                                <input type="number" class="form-control" name="filtro_id" id="filtro_id" autofocus="">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="filtro_nome" class="control-label">Nome</label>
                                <input type="text" class="form-control" name="filtro_nome" id="filtro_nome"
                                    placeholder="Digite uma palavra chave">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="control-label" for="filtro_status">Status</label>
                                <select class="form-control" name="filtro_status" id="filtro_status" style="width:100%">
                                    <option value="" disabled selected>Todos</option>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-1">
                            <label class="control-label">&nbsp;</label>
                            <button type="submit" class="run-search btn btn-secondary btn-block" data-toggle="tooltip"
                                data-placement="top" title="" id="btn-refresh"
                                data-original-title="Carregar resultados"><i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="col-1">
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
                        <table id="usuarioTable" class="table table-striped dataTable table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Perfil</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Editar</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\work\www\bkp_2024\cuboo_group\rpg\cuboo-rpg-admin\Modules/Usuario\Resources/views/index.blade.php ENDPATH**/ ?>