<?php

namespace Modules\Game\Services;

use DateTime;
use DateTimeZone;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Validator;
use Modules\Game\Repositories\GameRepository;

class GameService
{

   /**
    * @var GameRepository
    */
   private $repository;

   /**
    * Periodoervice constructor.
    * @param GameRepository $repository
    */
   public function __construct(GameRepository $repository)
   {
      $this->repository = $repository;
   }

   public function isValidate($arr)
   {
      return $v = Validator::make($arr, [
         'nome' => 'required|min:2|max:70',
      ]);
   }

   public function save($id = 0, $data)
   {
      $v = $this->isValidate($data);
      if ($v->fails()) {
         return __format_error_html($v);
      }

      if ($id) {
         $obj = $this->repository->find($id);
      } else {
         $obj = $this->repository;
      }

      if (user()->role_id > 2) {
         $data['users_id'] = user()->id;
      }

      $tema = DB::table('tema')->where('id', '=', $data['tema_id'])->first();
      $data['idioma'] = $tema->idioma;
      $data['date_expiracao'] = __date_iso_to_mysql($data['date_expiracao']);
      $obj->fill($data);
      $obj->save();


    // -------------------------------------------------
    // --- AGRUPADOR (aqui é o local correto!)
    // -------------------------------------------------
    $agrupadorId = null;

    if (!empty($data['novo_agrupador'])) {
        // cria novo agrupador
        $agrupadorId = DB::table('game_agrupador')->insertGetId([
            'nome'       => $data['novo_agrupador'],
            'game_id'    => $obj->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } elseif (!empty($data['agrupador_id'])) {
        // usa agrupador existente
        $agrupadorId = $data['agrupador_id'];
    }

    // vincula o game ao agrupador
    if ($agrupadorId) {
        DB::table('game')
            ->where('id', $obj->id)
            ->update(['agrupador_id' => $agrupadorId]);
    }
    // -------------------------------------------------

      return response()->json(['error' => 0, 'message' => 'O registro foi salvo com sucesso.', 'data' => ['id' => $obj->id]], 200);
   }

   public function create()
   {
      $d = new \DateTime();
      $d->add(new \DateInterval('P1D'));
      $temas = DB::table('tema')->orderBy('titulo')->get();
      $scenario = DB::table('scenarios')
         ->whereRaw("root_scenario_id IS NULL")
         ->get();
      $agrupadores = DB::table('game_agrupador')->get();

      return view('game::create', ['temas' => $temas, 'scenario' => $scenario,'agrupadores' => $agrupadores, 'date_expiracao' => $d->format('d/m/Y',)]);
   }

   public function edit($id)
   {
      // Busca o game
      $game = $this->repository->find($id);

      // Busca os usuários do game
      $gameUsuarios = DB::table('game_app_usuario AS GS')
         ->selectRaw("P.nome, P.email, GS.status,GS.total_points,
         SEC_TO_TIME(TIMESTAMPDIFF(SECOND, GS.created_at, GS.finished_at)) AS total_tempo")
         ->leftJoin('app_usuario AS P', 'GS.app_usuario_id', '=', 'P.id')
         ->where("GS.game_id", '=', $id)
         ->orderBy('P.nome')
         ->get();

      // Busca o tema do game
      $tema = DB::table('tema')->where('id', '=', $game->tema_id)->first();

      $scenarios = DB::table('scenarios')
         ->where('id', '=', $game->scenario_id)
         ->first();

         $agrupador = null;
         if ($game->agrupador_id) {
            $agrupador = DB::table('game_agrupador')->where('id', $game->agrupador_id)->first();
         }

      return view('game::edit', [
         'gameUsuarios' => $gameUsuarios,
         'game' => $game,
         'tema' => $tema,
         'scenarios' => $scenarios,
         'agrupador' => $agrupador,
      ]);
   }


   public function gm($chave)
   {
      $gameRow = DB::table('game')
         ->whereRaw("sha1(id) = '{$chave}'")
         ->first();

      $game = $this->repository->find($gameRow->id);
      $tema = DB::table('tema')->where('id', $game->tema_id)->first();

      $gameUsuarios = DB::table('game_app_usuario AS GS')
         ->selectRaw("
            GS.id,
            P.nome,
            P.email,
            GS.status,
            GS.total_points,
            SEC_TO_TIME(TIMESTAMPDIFF(SECOND, GS.created_at, GS.finished_at)) AS total_tempo
        ")
         ->leftJoin('app_usuario AS P', 'GS.app_usuario_id', '=', 'P.id')
         ->where("GS.game_id", $game->id)
         ->orderBy('P.nome')
         ->get();

      $scenarioRoot = $game->scenario_id;
      $scenariosBF = DB::table('scenarios')
         ->whereRaw("(id = ? OR root_scenario_id = ?)", [$scenarioRoot, $scenarioRoot])
         ->get();

      $scenariosById = $scenariosBF->keyBy('id');

      $optionsBF = DB::table('options')
         ->whereIn('scenario_id', $scenariosBF->pluck('id'))
         ->get();

      $optionsById = $optionsBF->keyBy('id');
      $optionsByScenario = [];
      foreach ($optionsBF as $op) {
         $optionsByScenario[$op->scenario_id][] = $op;
      }
      $perguntas = $scenariosBF->where('is_finally', 0);
      $finais    = $scenariosBF->where('is_finally', 1);

      $perguntasOrdenadas = $perguntas->sortBy('id');

      $listaCenarios = collect();

      foreach ($perguntasOrdenadas as $p) {
         $listaCenarios->push((object)[
            'scenario' => $p,
            'options'  => collect($optionsByScenario[$p->id] ?? [])
         ]);
      }

      foreach ($finais as $p) {
         $listaCenarios->push((object)[
            'scenario' => $p,
            'options'  => collect($optionsByScenario[$p->id] ?? [])
         ]);
      }

      $gameUsuarioIds = $gameUsuarios->pluck('id')->toArray();
      $respostas = DB::table('game_scenario_answers')
         ->whereIn('game_app_usuario_id', $gameUsuarioIds)
         ->get()
         ->groupBy('game_app_usuario_id');

      $respostasByUserByScenario = [];
      foreach ($respostas as $userId => $rows) {
         $respostasByUserByScenario[$userId] = $rows->groupBy('scenarios_id');
      }

      $finaisPorJogador = [];

      foreach ($gameUsuarios as $u) {

         $respUser = $respostas[$u->id] ?? collect();

         if ($respUser->isEmpty()) {
            $finaisPorJogador[$u->id] = null;
            continue;
         }

         $ultima = $respUser->sortBy('scenarios_id')->last();

         $optionId = $ultima->options_id ?? null;

         if (!$optionId || !isset($optionsById[$optionId])) {
            $finaisPorJogador[$u->id] = null;
            continue;
         }

         $finalScenarioId = $optionsById[$optionId]->next_scenario_id ?? null;

         if (
            $finalScenarioId
            && isset($scenariosById[$finalScenarioId])
            && $scenariosById[$finalScenarioId]->is_finally === 'S'
         ) {
            $finaisPorJogador[$u->id] = $finalScenarioId;
         } else {
            $finaisPorJogador[$u->id] = null;
         }
      }
      return view('admin::layouts/master_gm', [
         'estatistica' => view('game::gm', [
            'gameUsuarios'     => $gameUsuarios,
            'game'             => $game,
            'tema'             => $tema,
            'listaCenarios'    => $listaCenarios,
            'respostas'        => $respostas,
            'finaisPorJogador' => $finaisPorJogador
         ])
      ]);
   }

   public function downloadGM($chave)
   {
      $gameRow = DB::table('game')
         ->whereRaw("sha1(id) = '{$chave}'")
         ->first();
      $game = $this->repository->find($gameRow->id);

      $gameUsuarios = DB::table('game_app_usuario AS GS')
         ->selectRaw("
            GS.id,
            P.nome,
            P.email,
            GS.status,
            GS.total_points,
            SEC_TO_TIME(TIMESTAMPDIFF(SECOND, GS.created_at, GS.finished_at)) AS total_tempo
        ")
         ->leftJoin('app_usuario AS P', 'GS.app_usuario_id', '=', 'P.id')
         ->where("GS.game_id", $game->id)
         ->orderBy('P.nome')
         ->get();

      $scenarioRoot = $game->scenario_id;

      $allScenarios = DB::table('scenarios')
         ->whereRaw("(id = ? OR root_scenario_id = ?)", [$scenarioRoot, $scenarioRoot])
         ->orderBy('id')
         ->get()
         ->keyBy('id');

      $finals = $allScenarios->filter(fn($s) => $s->is_finally == 1);
      $scenarios = $allScenarios->filter(fn($s) => $s->is_finally == 0);

      $optionsBF = DB::table('options')
         ->whereIn('scenario_id', $allScenarios->pluck('id'))
         ->get();

      $optionsById = $optionsBF->keyBy('id');

      $respostas = DB::table('game_scenario_answers')
         ->whereIn('game_app_usuario_id', $gameUsuarios->pluck('id'))
         ->get()
         ->groupBy('game_app_usuario_id');

      $csv = "Jogador;Email;TotalPontos;TempoTotal";

      foreach ($scenarios as $s) {
         $csv .= ";" . $s->title;
      }

      foreach ($finals as $fid => $fname) {
         $csv .= ";Final - " . $fname->title;
      }
      $csv .= "\n";

      foreach ($gameUsuarios as $u) {

         $csv .=
            ($u->nome ?? '') . ";" .
            ($u->email ?? '') . ";" .
            ($u->total_points ?? '') . ";" .
            ($u->total_tempo ?? '');

         $linhaPerguntas = array_fill_keys($scenarios->keys()->toArray(), "");
         $respUser = $respostas[$u->id] ?? collect();
         $ultimaResposta = null;

         foreach ($respUser as $r) {
            $option = $optionsById[$r->options_id] ?? null;

            if ($option) {
               $linhaPerguntas[$r->scenarios_id] =
                  !empty($r->message) ? $r->message : $option->title;
               $ultimaResposta = $r;
            }
         }

         foreach ($linhaPerguntas as $resp) {
            $csv .= ";" . $resp;
         }

         $finalDoJogador = null;

         if ($ultimaResposta) {
            $optionId = $ultimaResposta->options_id;
            $op = $optionsById[$optionId] ?? null;

            if ($op && $op->next_scenario_id) {
               $next = $op->next_scenario_id;

               if (isset($allScenarios[$next]) && $allScenarios[$next]->is_finally == 1) {
                  $finalDoJogador = $next;
               }
            }
         }

         foreach ($finals as $fid => $fname) {
            $csv .= ";" . ($fid == $finalDoJogador ? "X" : "");
         }

         $csv .= "\n";
      }

      $fileName = "gm_game_{$game->id}.csv";

      header('Content-Type: text/csv; charset=UTF-8');
      header("Content-Disposition: attachment; filename=\"$fileName\"");

      echo $csv;
      exit;
   }

   // Força a finalização da partida.
   public function finalizaPartida($id)
   {
      try {
         $obj = $this->repository->find($id);
         $obj->ativo = 'N';
         $obj->status = 2;
         $obj->save();
         return response()->json(['error' => 0, 'message' => 'O partida esta sendo finalizada com sucesso.', 'data' => []], 200);
      } catch (\Exception $e) {
         return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 400);
      }
   }

   public function destroy($id)
   {
      $obj = $this->repository->find($id);
      $obj->delete();
      return response()->json(['error' => 0, 'message' => 'O registro foi removido com sucesso.', 'data' => []], 200);
   }

   /**
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
   public function findAll(Request $request)
   {
      try {

         $order = $request->get('order');
         $search = $request->get('search');

         $search['id'] = (int)$search['id'];
         $search['nome'] = filter_var($search['nome'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

         switch ((int)$order[0]['column']) {
            case 0:
               $sort = 'id';
               break;
            case 1:
               $sort = 'nome';
               break;
            case 2:
               $sort = 'idioma';
               break;
            case 3:
               $sort = 'LINK';
               break;
            case 4:
               $sort = 'GM';
               break;
            case 5:
               $sort = 'MESTRE';
               break;
            case 6:
               $sort = 'RANKING';
               break;
         }

         $start = (int)$request->get('start');
         $limit = (int)$request->get('length');

         $query_params = [
            'start' => $start,
            'limit' => $limit,
            'sort' => $sort,
            'dir' => $order[0]['dir'],
            'search' => $search,
         ];

         $query_params['search']['users_id'] = user()->id;
         $result = $this->repository->findAll($query_params);

         $draw = (int)$request->get('draw');

         $draw++;

         $response = [
            'success' => true,
            'draw' => $draw,
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data' => $result['data']
         ];
      } catch (\Exception $e) {

         $response = [
            'message' => $e->getMessage()
         ];
      } finally {

         return response()->json($response, 200);
      }
   }
}
