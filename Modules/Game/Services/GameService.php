<?php

namespace Modules\Game\Services;

use DateTime;
use DateTimeZone;
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

      return view('game::create', ['temas' => $temas, 'scenario' => $scenario, 'date_expiracao' => $d->format('d/m/Y',)]);
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

      return view('game::edit', [
         'gameUsuarios' => $gameUsuarios,
         'game' => $game,
         'tema' => $tema,
         'scenarios' => $scenarios,
      ]);
   }


   public function gm($chave)
   {
      $game = DB::table('game')
         ->whereRaw("sha1(id) = '{$chave}'")
         ->first();

      $game = $this->repository->find($game->id);
      $gameUsuarios = DB::table('game_app_usuario AS GS')
         ->selectRaw("P.nome, P.email, GS.status,GS.total_points,
         SEC_TO_TIME(TIMESTAMPDIFF(SECOND, GS.created_at, GS.finished_at)) AS total_tempo")
         ->leftJoin('app_usuario AS P', 'GS.app_usuario_id', '=', 'P.id')
         ->where("GS.game_id", '=', $game->id)
         ->orderBy('P.nome')
         ->get();

      $tema = DB::table('tema')->where('id', '=', $game->tema_id)->first();




      $estatistica = view('game::gm', ['gameUsuarios' => $gameUsuarios, 'game' => $game, 'tema' => $tema,]);

      return view('admin::layouts/master_gm', ['estatistica' =>  $estatistica]);
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
