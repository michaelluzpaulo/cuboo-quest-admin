<form id="institucionalForm" role="form" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="institucionalModalLabel">Institucional / #<?php echo $institucional->id; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <input type="hidden" name="id" id="id" value="<?php echo $institucional->id; ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="titulo" class="control-label">Título: </label>
                    <input type="text" class="form-control" name="titulo" id="titulo" maxlength="70"
                        value="<?php echo $institucional->titulo; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="ref_amigavel" class="control-label">Ref. Amigável: </label>
                    <input type="text" class="form-control" name="ref_amigavel" id="ref_amigavel" readonly
                        value="<?php echo $institucional->ref_amigavel; ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="ordem" class="control-label">Ordem: </label>
                    <input type="number" class="form-control" name="ordem" id="ordem"
                        value="<?php echo $institucional->ordem; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    <label for="empresa_id" class="control-label">Empresa: </label>
                    <select class="form-control" name="empresa_id" id="empresa_id" required>
                        <option value="">SELECIONE...</option>
                        <?php
                        foreach ($empresas as $row) {
                            echo "<option value='{$row->id}' " . ($row->id == $institucional->empresa_id ? ' selected ' : '') . ">{$row->nome}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="texto" class="control-label">Texto: </label>
                    <textarea class="form-control ckeditor" name="texto" id="texto" rows="8"><?php echo $institucional->texto; ?></textarea>
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
