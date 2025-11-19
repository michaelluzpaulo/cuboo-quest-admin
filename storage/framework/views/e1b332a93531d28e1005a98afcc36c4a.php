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
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="fundo_img" class="control-label">Imagem de fundo "background" (2000px): </label>
                    <input type="file" class="form-control" name="fundo_img" id="fundo_img" />
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <hr />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_title_time" class="control-label">Título game time </label>
                    <input type="text" class="form-control" name="game_title_time" id="game_title_time"
                        value="O tempo não para!" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_cronometro" class="control-label">Cronometro em minutos game </label>
                    <input type="number" class="form-control" name="game_cronometro" id="game_cronometro"
                        value="60" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="senha_sala_1_final" class="control-label">Senha sala 1 final: </label>
                    <input type="text" class="form-control" name="senha_sala_1_final" id="senha_sala_1_final" maxlength="255">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="senha_sala_2_final" class="control-label">Senha sala 2 final: </label>
                    <input type="text" class="form-control" name="senha_sala_2_final" id="senha_sala_2_final" maxlength="255">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="senha_sala_3_final" class="control-label">Senha sala 3 final: </label>
                    <input type="text" class="form-control" name="senha_sala_3_final" id="senha_sala_3_final" maxlength="255">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_title_input" class="control-label">Título do input game </label>
                    <input type="text" class="form-control" name="game_title_input" id="game_title_input"
                        value="Tente a sorte!" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_title_btn" class="control-label">Título do botão game </label>
                    <input type="text" class="form-control" name="game_title_btn" id="game_title_btn"
                        value="Pesquisar" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="game_fonte_cor" class="control-label">Cor da fonte game </label>
                    <input type="color" class="form-control" name="game_fonte_cor" id="game_fonte_cor" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="game_bg_btn_cor" class="control-label">Cor de fundo botão game </label>
                    <input type="color" class="form-control" name="game_bg_btn_cor" id="game_bg_btn_cor" />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="game_fundo_cor" class="control-label">Cor de fundo game </label>
                    <input type="color" class="form-control" name="game_fundo_cor" id="game_fundo_cor" />
                </div>
            </div>
             <div class="col-lg-12">
                <div class="form-group">
                    <hr />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_img" class="control-label">Imagem de fundo game 1 (2000px): </label>
                    <input type="file" class="form-control" name="game_fundo_img" id="game_fundo_img" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_img_2" class="control-label">Imagem de fundo game 2 (2000px): </label>
                    <input type="file" class="form-control" name="game_fundo_img_2" id="game_fundo_img_2" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_img_3" class="control-label">Imagem de fundo game 3 (2000px): </label>
                    <input type="file" class="form-control" name="game_fundo_img_3" id="game_fundo_img_3" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_img_sabotador" class="control-label">Sabotador - Imagem de fundo game 1 (2000px): </label>
                    <input type="file" class="form-control" name="game_fundo_img_sabotador" id="game_fundo_img_sabotador" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_img_2_sabotador" class="control-label">Sabotador - Imagem de fundo game 2 (2000px): </label>
                    <input type="file" class="form-control" name="game_fundo_img_2_sabotador" id="game_fundo_img_2_sabotador" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_img_3_sabotador" class="control-label">Sabotador - Imagem de fundo game 3 (2000px): </label>
                    <input type="file" class="form-control" name="game_fundo_img_3_sabotador" id="game_fundo_img_3_sabotador" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="game_fundo_central_img" class="control-label">Imagem do Modal (2000px):
                    </label>
                    <input type="file" class="form-control" name="game_fundo_central_img"
                        id="game_fundo_central_img" />
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="form-group">
                    <hr />
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
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="texto_erro_dica_nao_encontrada" class="control-label">Texto erro dica não encontrada:
                    </label>
                    <input type="text" class="form-control" name="texto_erro_dica_nao_encontrada"
                        id="texto_erro_dica_nao_encontrada" maxlength="100" value="Nenhuma dica encontrada">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="texto_inicial" class="control-label">Texto inicial: </label>
                    <textarea class="form-control ckeditor" name="texto_inicial" id="texto_inicial" rows="8"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="texto_final" class="control-label">Texto final acerto: </label>
                    <textarea class="form-control ckeditor" name="texto_final" id="texto_final" rows="8"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="texto_final_falha" class="control-label">Texto mensagem final falha: </label>
                    <textarea class="form-control ckeditor" name="texto_final_falha" id="texto_final_falha" rows="8"></textarea>
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
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\mestre_dos_magos\mestre_dos_magos-web\Modules/Tema\Resources/views/create.blade.php ENDPATH**/ ?>