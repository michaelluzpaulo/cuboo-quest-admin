<div class="modal-header">
    <h4 class="modal-title" id="gameModalLabel">Game / #
        <?php echo $game->id; ?>
    </h4>
</div>
<div class="modal-body">
    <form id="gameForm">
        <input type="hidden" name="id" id="id" value="<?php echo $game->id; ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome" class="control-label">Nome: </label>
                    <input type="text" class="form-control" name="nome" id="nome" maxlength="70"
                        value="<?php echo $game->nome; ?>" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tema" class="control-label">Tema: </label>
                    <input type="text" class="form-control" name="tema" id="tema" maxlength="70"
                        value="<?php echo $tema->titulo . " ({$tema->idioma})"; ?>" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ativox" class="control-label">Status: </label>
                    <input type="text" class="form-control" name="ativox" id="ativox" value="<?php echo $game->ativo == 'S' ? 'Ativado' : 'Inativado'; ?>"
                        disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="date_expiracaox" class="control-label">Data expiração: </label>
                    <input type="text" class="form-control" name="date_expiracaox" id="date_expiracaox"
                        value="<?php echo __date_mysql_to_iso($game->date_expiracao); ?>" disabled>
                </div>
            </div>
            
            <div class="col-md-2">
                <div class="form-group">
                    <label for="game_time2" class="control-label">Game Inicio: </label>
                    <input type="text" class="form-control" name="game_time2" id="game_time2" maxlength="70"
                        value="<?php echo __date_time_mysql_to_iso($game->game_time); ?>" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="game_time3" class="control-label">Game Final: </label>
                    <input type="text" class="form-control" name="game_time3" id="game_time3" maxlength="70"
                        value="<?php echo __date_time_mysql_to_iso($game->game_time_final); ?>" disabled>
                </div>
            </div>


            


            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <h4><b>Players</b></h4>
                <div style="overflow-x: auto">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Nome
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Total Pontos
                                </th>
                                <th>
                                    Total Tempo
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $gameUsuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($g->nome); ?>

                                    </td>
                                    <td>
                                        <?php echo e($g->email); ?>

                                    </td>
                                    <td>
                                        <?php echo e($g->total_points); ?>

                                    </td>
                                    <td>
                                        <?php echo e($g->total_tempo); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <br /><br />
</div>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\quest_group\cuboo-quest-admin\Modules/Game\Resources/views/gm.blade.php ENDPATH**/ ?>