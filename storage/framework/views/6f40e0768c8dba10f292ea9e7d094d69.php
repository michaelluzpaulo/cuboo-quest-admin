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
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\jogo_perguntas\admin\Modules/Tema\Resources/views/edit.blade.php ENDPATH**/ ?>