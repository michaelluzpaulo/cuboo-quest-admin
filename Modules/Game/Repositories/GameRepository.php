<?php

namespace Modules\Game\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\Admin\Repositories\RepositoryInterface;

/**
 * Class PeriodoRepository
 * @package Modules\Cadastro\Repositories
 */
class GameRepository extends AbstractRepository implements RepositoryInterface
{
   protected $table = "game";
   protected $fillable = ['nome', 'ativo', 'game_time', 'game_time_final', 'created_at', 'updated_at', 'users_id', 'idioma', 'date_expiracao', 'tema_id', 'status', 'final_game_at', 'scenario_id'];
   //protected $guarded = ['id'];
   public $timestamps = true;

   const STATUS_INITIAL = 1;
   const STATUS_SUCCESS_PLAYERS = 2;
   const STATUS_ERROR = 3;

   /**
    * @param array $query_params
    * @return array
    */

   // coloquei isso INICIO

   // public function findGame($id)
   // {
   //    return DB::table($this->table)->where('id', $id)->first();
   // }

   // Retorna todos os jogadores encontrados
   // public function getPlayersBySala($gameId, $sala)
   // {
   //    return DB::table('game_app_usuario')
   //       ->where('game_id', $gameId)
   //       ->where('sala', $sala)
   //       ->get();
   // }

   // Encerrar o jogo e gravar quem venceu no banco
   // public function finalizaPartida($gameId, $vencedor)
   // {
   //    $status = $vencedor === 'usuarios' ? 2 : 3;

   //    DB::table($this->table)
   //       ->where('id', $gameId)
   //       ->update([
   //          'status' => $status,
   //          // 'status' => 2,
   //          'final_game_at' => now(),
   //          'sabotador' => $vencedor === 'sabotador' ? 'sim' : null
   //       ]);

   //    if ($vencedor === 'usuarios') {
   //       DB::table('game_app_usuario')
   //          ->where('game_id', $gameId)
   //          ->update(['status' => 'vencedor']);
   //       DB::table('game_app_usuario')
   //          ->where('game_id', $gameId)
   //          ->where('is_sabotador', 1)
   //          ->update(['status' => 'perdeu']);
   //    } else {
   //       DB::table('game_app_usuario')
   //          ->where('game_id', $gameId)
   //          ->update(['status' => 'perdeu']);
   //    }
   // }

   //helper do repositório para verificar se o jogador já cumpriu o objetivo de senha dentro da partida.
   // public function hasPlayerAnsweredPassword($gameId, $userId)
   // {
   //    $player = DB::table('game_app_usuario')
   //       ->where('game_id', $gameId)
   //       ->where('app_usuario_id', $userId)
   //       ->first();

   //    return $player ? (bool) $player->is_quest_password : false;
   // }

   // coloquei isso FIM



   public function findAll(array $query_params): array
   {
      $params = [];

      // Carrega os registro conforme filtros aplicados.
      $select = DB::table('game AS G')
         ->selectRaw('G.*, T.titulo AS TEMA')
         ->join('tema AS T', 'T.id', '=', 'G.tema_id');

      if (user()->role_id > 2) {
         $select->where(['G.users_id' => $query_params['search']['users_id']]);
      }

      if ($query_params['search']['id'] > 0) {
         $select->where(['G.id' => (int)$query_params['search']['id']]);
      }

      if (!empty($query_params['search']['nome'])) {
         $select->where('G.nome', 'LIKE', "%{$query_params['search']['nome']}%");
      }

      // Execute for get the total records filtered
      $result = $select->get();

      $recordsFiltered = $result->count();

      if ($query_params['limit'] >= 0) {
         $select->offset($query_params['start'])->limit($query_params['limit']);
      }

      // set order by
      $select->orderBy($query_params['sort'], $query_params['dir']);

      // Execute for get the result data
      $result = $select->get();

      $data = [];

      $url = env('APP_ENV') == 'local' ? "http://localhost:3000" : "https://";
      $urlGM = env('APP_ENV') == 'local' ? "http://localhost:8000" : "https://rpg-admin.cuboogame.com";
      $d1 = new \DateTime(date('Y-m-d H:i:s'));

      foreach ($result as $row) {
         $url2 = env('APP_ENV') == 'local' ? "http://localhost:3000" : "https://rpg.cuboogame.com";
         $chave = sha1($row->id);

         $d2 = new \DateTime($row->date_expiracao . ' 23:59:59');

         $status = 'Ativo';
         if ($row->ativo == 'N') {
            $status = 'Inativo';
         } else if ($row->date_expiracao && $d1 > $d2) {
            $status = 'Expirado';
         }

         $data[] = [
            'DT_RowId' => $row->id,
            $row->id,
            $row->nome,
            $row->TEMA,
            $row->idioma,
            $status,
            "<a href='{$url2}/login/" . $chave . "' target='_blank'>{$url2}/login/" . $chave . "</a>",
            "<a href='{$urlGM}/gm/" . $chave . "' target='_blank'>Link</a>"
         ];
      }

      // Set total amount of table
      if (count($params)) {
         $recordsTotal = $this->count();
      } else {
         $recordsTotal = $recordsFiltered;
      }

      return [
         'recordsFiltered' => $recordsFiltered,
         'recordsTotal' => $recordsTotal,
         'data' => $data
      ];
   }
}
