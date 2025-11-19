<form id="temaForm" role="form" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="temaModalLabel">Tema / #
            <?php echo $tema->id; ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <input type="hidden" name="id" id="id" value="<?php echo $tema->id; ?>">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="titulo" class="control-label">Título: </label>
                    <input type="text" class="form-control" name="titulo" id="titulo" maxlength="70"
                        value="<?php echo $tema->titulo; ?>">
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">
                    <label for="idioma" class="control-label">Idioma: </label>
                    <select class="form-control" name="idioma" id="idioma" required>
                        <?php
                        foreach ($idiomas as $row) {
                            echo "<option value='{$row->sigla}' " . ($row->sigla == $tema->idioma ? ' selected ' : '') . ">{$row->nome}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">
                    <label for="cor_fonte" class="control-label">Cor da fonte da página </label>
                    <input type="color" class="form-control" name="cor_fonte" id="cor_fonte"
                        value="<?php echo $tema->cor_fonte; ?>" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="fundo_cor" class="control-label">Cor de fundo </label>
                    <input type="color" class="form-control" name="fundo_cor" id="fundo_cor"
                        value="<?php echo $tema->fundo_cor; ?>" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="bg_btn_cor" class="control-label">Cor fundo dos botões </label>
                    <input type="color" class="form-control" name="bg_btn_cor" id="bg_btn_cor"
                        value="<?php echo $tema->bg_btn_cor; ?>" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="text_btn_cor" class="control-label">Cor da fonte do botão: </label>
                    <input type="color" class="form-control" name="text_btn_cor" id="text_btn_cor"
                        value="<?php echo $tema->text_btn_cor; ?>" />
                </div>
            </div>


            <div class="col-lg-6">
                <div class="form-group">
                    <label for="texto_erro_geral" class="control-label">Texto erro geral: </label>
                    <input type="text" maxlength="100" class="form-control" name="texto_erro_geral"
                        id="texto_erro_geral" value="<?php echo $tema->texto_erro_geral; ?>">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="texto_erro_dica_nao_encontrada" class="control-label">Texto erro dica não encontrada:
                    </label>
                    <input type="text" maxlength="100" class="form-control" name="texto_erro_dica_nao_encontrada"
                        id="texto_erro_dica_nao_encontrada" value="<?php echo $tema->texto_erro_dica_nao_encontrada; ?>">
                </div>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="logo_img" class="control-label">Logo (400px): </label>
                    <input type="file" class="form-control" name="logo_img" id="logo_img" />
                    <?php if($tema->logo_img): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'logo_img')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->logo_img): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->logo_img}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="marca_img" class="control-label">Marca (400px): </label>
                    <input type="file" class="form-control" name="marca_img" id="marca_img" />
                    <?php if($tema->marca_img): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'marca_img')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->marca_img): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->marca_img}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="fundo_img" class="control-label">Imagem de fundo "background" (2000px): </label>
                    <input type="file" class="form-control" name="fundo_img" id="fundo_img" />
                    <?php if($tema->fundo_img): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'fundo_img')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->fundo_img): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->fundo_img}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_title_time" class="control-label">Título game time </label>
                    <input type="text" class="form-control" name="game_title_time" id="game_title_time"
                        value="<?php echo $tema->game_title_time; ?>" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_cronometro" class="control-label">Cronometro em minutos game </label>
                    <input type="number" class="form-control" name="game_cronometro" id="game_cronometro"
                        value="<?php echo $tema->game_cronometro; ?>" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="senha_sala_1_final" class="control-label">Senha sala 1 final (separados por ";")
                    </label>
                    <input type="text" class="form-control" name="senha_sala_1_final" id="senha_sala_1_final"
                        value="<?php echo $tema->senha_sala_1_final; ?>">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="senha_sala_2_final" class="control-label">Senha sala 2 final (separados por ";")
                    </label>
                    <input type="text" class="form-control" name="senha_sala_2_final" id="senha_sala_2_final"
                        value="<?php echo $tema->senha_sala_2_final; ?>">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="senha_sala_3_final" class="control-label">Senha sala 3 final (separados por ";")
                    </label>
                    <input type="text" class="form-control" name="senha_sala_3_final" id="senha_sala_3_final"
                        value="<?php echo $tema->senha_sala_3_final; ?>">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_title_input" class="control-label">Título do input game </label>
                    <input type="text" class="form-control" name="game_title_input" id="game_title_input"
                        value="<?php echo $tema->game_title_input; ?>" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_title_btn" class="control-label">Título do botão game </label>
                    <input type="text" class="form-control" name="game_title_btn" id="game_title_btn"
                        value="<?php echo $tema->game_title_btn; ?>" />
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">
                    <label for="game_fonte_cor" class="control-label">Cor da fonte game </label>
                    <input type="color" class="form-control" name="game_fonte_cor" id="game_fonte_cor"
                        value="<?php echo $tema->game_fonte_cor; ?>" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="game_bg_btn_cor" class="control-label">Cor de fundo botão game </label>
                    <input type="color" class="form-control" name="game_bg_btn_cor" id="game_bg_btn_cor"
                        value="<?php echo $tema->game_bg_btn_cor; ?>" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="game_fundo_cor" class="control-label">Cor de fundo game </label>
                    <input type="color" class="form-control" name="game_fundo_cor" id="game_fundo_cor"
                        value="<?php echo $tema->game_fundo_cor; ?>" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_sabotador_title" class="control-label">Título do sabotador </label>
                    <input type="text" class="form-control" name="game_sabotador_title" id="game_sabotador_title"
                        value="<?php echo $tema->game_sabotador_title; ?>" />
                </div>
            </div>


            <div class="col-lg-12">
                <hr />
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Imagem de fundo game 1 (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_img" id="game_fundo_img" />
                    <?php if($tema->game_fundo_img): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'game_fundo_img')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->game_fundo_img): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->game_fundo_img}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Imagem de fundo game 2 (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_img_2" id="game_fundo_img_2" />
                    <?php if($tema->game_fundo_img_2): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'game_fundo_img_2')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->game_fundo_img_2): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->game_fundo_img_2}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Imagem de fundo game 3 (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_img_3" id="game_fundo_img_3" />
                    <?php if($tema->game_fundo_img_3): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'game_fundo_img_3')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->game_fundo_img_3): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->game_fundo_img_3}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>
               <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Sabotador - Imagem de fundo game 1 (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_img_sabotador" id="game_fundo_img_sabotador" />
                    <?php if($tema->game_fundo_img_sabotador): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'game_fundo_img_sabotador')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->game_fundo_img_sabotador): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->game_fundo_img_sabotador}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>
               <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Sabotador - Imagem de fundo game 2 (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_img_2_sabotador" id="game_fundo_img_2_sabotador" />
                    <?php if($tema->game_fundo_img_2_sabotador): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'game_fundo_img_2_sabotador')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->game_fundo_img_2_sabotador): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->game_fundo_img_2_sabotador}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>
               <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Sabotador - Imagem de fundo game 3 (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_img_3_sabotador" id="game_fundo_img_3_sabotador" />
                    <?php if($tema->game_fundo_img_3_sabotador): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button" onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'game_fundo_img_3_sabotador')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->game_fundo_img_3_sabotador): ?>
                    <br />
                    <img class="img-responsive pad" src="<?php echo e(asset("storage/tema/tmb_{$tema->game_fundo_img_3_sabotador}")); ?>"
                        alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Imagem do Modal (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_central_img"
                        id="game_fundo_central_img" />
                    <?php if($tema->game_fundo_central_img): ?>
                        <p align="center " style="padding: 30px">
                            <button type="button"
                                onclick="Tema.deleteFoto(<?php echo $tema->id; ?>,'game_fundo_central_img')"
                                class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                                Excluir Imagem
                            </button>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <?php if($tema->game_fundo_central_img): ?>
                    <br />
                    <img class="img-responsive pad"
                        src="<?php echo e(asset("storage/tema/tmb_{$tema->game_fundo_central_img}")); ?>" alt="Imagem" />
                <?php endif; ?>
            </div>

            <div class="col-lg-12">
                <hr />
            </div>



            <div class="col-lg-12">
                <div class="form-group">
                    <label for="texto_inicial" class="control-label">Texto inicial: </label>
                    <textarea class="form-control ckeditor" name="texto_inicial" id="texto_inicial" rows="12"><?php echo $tema->texto_inicial; ?></textarea>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="texto_final" class="control-label">Texto final acerto: </label>
                    <textarea class="form-control ckeditor" name="texto_final" id="texto_final" rows="12"><?php echo $tema->texto_final; ?></textarea>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label for="texto_final_falha" class="control-label">Texto final falha:
                    </label>
                    <textarea class="form-control ckeditor" name="texto_final_falha" id="texto_final_falha" rows="12"><?php echo $tema->texto_final_falha; ?></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="game_sabotador_description" class="control-label">Texto Sabotador:
                    </label>
                    <textarea class="form-control ckeditor" name="game_sabotador_description" id="game_sabotador_description" rows="12"><?php echo $tema->game_sabotador_description; ?></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="game_after_password_modal_text" class="control-label">Texto Modal Pós Acerto da Senha:
                    </label>
                    <textarea class="form-control ckeditor" name="game_after_password_modal_text" id="game_after_password_modal_text" rows="12"><?php echo $tema->game_after_password_modal_text; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i class="bi bi-door-closed"></i>
            Fechar
        </button>
        <button type="button" class="btn btn-info  js-run-clone" data-bs-dismiss="modal">
            <i class="far fa-clone"></i>
            Clonar
        </button>
        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Salvar</button>
        <button type="button" class="btn btn-danger js-run-delete"><i class="bi bi-trash"></i> Excluir</button>
    </div>
</form>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\rpg\cuboo-rpg-admin\Modules/Tema\Resources/views/edit.blade.php ENDPATH**/ ?>
