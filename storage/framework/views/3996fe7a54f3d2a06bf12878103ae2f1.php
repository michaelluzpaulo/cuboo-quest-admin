<form id="gameForm" role="form" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="gameModalLabel">Game / #
            <?php echo $game->id; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

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
                    <label for="temax" class="control-label">Tema: </label>
                    <input type="text" class="form-control" name="temax" id="temax" maxlength="70"
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
                    <?php

                    $d1 = new DateTime($game->game_time);
                    $d2 = new DateTime($game->final_game_at);
                    $diff = $d1->diff($d2);
                    $t = $diff->format('%h') * 60 + $diff->format('%i');
                    $t = $t > 0 ? $t : 0;

                    ?>
                    <label for="game_time1" class="control-label">Tempo de Game:
                    </label>
                    <input type="text" class="form-control" name="game_time1" id="game_time1" maxlength="70"
                        value="<?php echo $t; ?>" disabled>
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
                    <label for="game_time3" class="control-label">Game Final Termino: </label>
                    <input type="text" class="form-control" name="game_time3" id="game_time3" maxlength="70"
                        value="<?php echo __date_time_mysql_to_iso($game->final_game_at); ?>" disabled>
                </div>
            </div>


            <div class="col-md-2">
                <div class="form-group">
                    <label for="game_time3" class="control-label">Game Final Previsto: </label>
                    <input type="text" class="form-control" name="game_time3" id="game_time3" maxlength="70"
                        value="<?php echo __date_time_mysql_to_iso($game->game_time_final); ?>" disabled>
                </div>
            </div>

            <?php if($game->ativo == 'S'): ?>
                <div class="col-md-12">
                    <hr />
                </div>
                <div class="col-md-12">
                    <div class="form-group" style="text-align: center">
                        <button type="button" class="btn btn-primary run-finaliza-partida-manual">Finalizar
                            Partida</button>
                    </div>
                </div>
            <?php endif; ?>

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
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <hr />
            </div>
        </div>
        <br /><br />
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i class="bi bi-door-closed"></i>
            Fechar
        </button>
        
        <button type="button" class="btn btn-danger run-btn-delete"><i class="bi bi-trash"></i> Excluir</button>
    </div>
</form>
<?php /**PATH /Volumes/work/www/cuboo_group/think_group/adm/Modules/Game/Resources/views/edit.blade.php ENDPATH**/ ?>