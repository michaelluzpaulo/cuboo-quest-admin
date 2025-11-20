<form id="temaForm" role="form">
    <div class="modal-header">
        <h5 class="modal-title" id="temaModalLabel">Tema / Novo cadastro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="0">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="titulo" class="control-label">Título: </label>
                    <input type="text" class="form-control" name="titulo" id="titulo" maxlength="70">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="idioma" class="control-label">Idioma: </label>
                    <select class="form-control" name="idioma" id="idioma" required>
                        <option value="">Selecione...</option>
                        <?php
                        foreach ($idiomas as $row) {
                            echo "<option value='{$row->sigla}'>{$row->nome}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="cor_fonte" class="control-label">Cor da fonte da página: </label>
                    <input type="color" class="form-control" name="cor_fonte" id="cor_fonte" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="bg_btn_cor" class="control-label">Cor fundo dos botões: </label>
                    <input type="color" class="form-control" name="bg_btn_cor" id="bg_btn_cor" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="text_btn_cor" class="control-label">Cor da fonte do botão: </label>
                    <input type="color" class="form-control" name="text_btn_cor" id="text_btn_cor" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="fundo_cor" class="control-label">Cor de fundo </label>
                    <input type="color" class="form-control" name="fundo_cor" id="fundo_cor" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="select_board_cor" class="control-label">Cor da Borda nas opções: </label>
                    <input type="color" class="form-control" name="select_board_cor" id="select_board_cor" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="text_ranking" class="control-label">Texto para Ranking </label>
                    <textarea class="form-control ckeditor" name="text_ranking" id="text_ranking" rows="8"></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="logo_img" class="control-label">Logo (400px): </label>
                    <input type="file" class="form-control" name="logo_img" id="logo_img" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="marca_img" class="control-label">Marca (400px): </label>
                    <input type="file" class="form-control" name="marca_img" id="marca_img" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="fundo_img" class="control-label">Imagem de fundo "background" (2000px): </label>
                    <input type="file" class="form-control" name="fundo_img" id="fundo_img" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="texto_erro_geral" class="control-label">Texto erro geral:
                    </label>
                    <input type="text" class="form-control" name="texto_erro_geral" id="texto_erro_geral"
                        maxlength="100" value="Não foi encontrado nenhum registro">
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
</form>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\quest_group\cuboo-quest-admin\Modules/Tema\Resources/views/create.blade.php ENDPATH**/ ?>