<form id="dicaForm" role="form" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="dicaModalLabel">Dica / #<?php echo $dica->id; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <input type="hidden" name="id" id="id" value="<?php echo $dica->id; ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="intent" class="control-label">Intent (palavras separadas por ";") </label>
                    <input type="text" class="form-control" name="intent" id="intent" maxlength="255"
                        value="<?php echo $dica->intent; ?>">
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="tema_id" class="control-label">Tema </label>
                    <select class="form-control" name="tema_id" id="tema_id" required>
                        <option value="">Selecione...</option>
                        <?php
                        foreach ($temas as $row) {
                            echo "<option value='{$row->id}' {{ $row->id == $dica->tema_id ? ' selected ' : '' }}>{$row->titulo} ({$row->idioma})</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="texto" class="control-label">Texto: </label>
                    <textarea class="form-control ckeditor" name="texto" id="texto" rows="8"><?php echo $dica->texto; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i class="bi bi-door-closed"></i>
            Fechar
        </button>
        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Salvar</button>
        <button type="button" class="btn btn-danger run-btn-delete"><i class="bi bi-trash"></i> Excluir</button>
    </div>
</form>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\mestre_dos_magos\mestre_dos_magos-web\Modules/Dica\Resources/views/edit.blade.php ENDPATH**/ ?>