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
            <div class="col-md-2">
                <div class="form-group">
                    <label for="download" class="control-label">Download</label>
                     <a href="{{ route('games.downloadGM', ['chave' => sha1($game->id)]) }}"
   class="btn btn-primary btn-block"
   target="_blank">
   Download
</a>
                </div>
            </div>

            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-12">
                <h4><b>Players</b></h4>
                <div style="overflow-x: auto; width: 100%; ">
                    <table class="table table-striped table-bordered">
                        <thead>
                           <tr>
                                 <th>Nome</th>
                                 <th>Email</th>
                                  <th>Pontos</th>
                                 <th>Tempo</th>
                                 @foreach($listaCenarios as $item)
                                  <th>
                                 {{ $item->scenario->title }}
                                 @if($item->scenario->is_finally === 'S')
                                     (Final)
                                 @endif
                                 </th>
                                 @endforeach
                          </tr>
                        </thead>
                         <tbody>
                            @foreach($gameUsuarios as $u)
                              @php
                                          $respUser = $respostas[$u->id] ?? collect();
                                      $finalDoJogador = $finaisPorJogador[$u->id] ?? null;
                                     @endphp
                                  <tr>
                                      <td>{{ $u->nome }}</td>
                                     <td>{{ $u->email }}</td>
                                     <td>{{ $u->total_points }}</td>
                                    <td>{{ $u->total_tempo }}</td>
                                @foreach($listaCenarios as $item)
                                     @php
                                       $cenario = $item->scenario;
                                       $idCenario = $cenario->id;
                                       $isFinal = $cenario->is_finally === 'S';
                                       $resp = $respUser->firstWhere('scenarios_id', $idCenario);
                                    @endphp
                                  <td class="text-center">
                                     @if(!$isFinal)
                                       @if($resp)
                                          <span style="color: green; font-weight: bold;">✔</span>
                                          @if(!empty($resp->message))
                                              <div style="font-size: 11px; color: #444; margin-top: 4px; text-align:left;">
                                                  <strong>Mensagem:</strong><br>
                                                  {{ $resp->message }}
                                              </div>
                                          @endif
                                      @endif
                                         @else
                                             @if($idCenario == $finalDoJogador)
                                                 <span style="color:red;font-weight:bold;">✔ FINAL</span>
                                             @endif
                                         @endif

                                  </td>
                        @endforeach
                      </tr>
                       @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <br /><br />
</div>
