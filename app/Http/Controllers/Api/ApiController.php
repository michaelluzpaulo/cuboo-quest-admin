<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth; //use this library

class ApiController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth:api', ['except' => ['login', 'register', 'tema']]);
   }

   protected function getDecodeToken()
   {
      $token = JWTAuth::getToken();
      $user = JWTAuth::getPayload($token)->toArray();
      return $user;
   }

   public function goPlayersGame($id)
   {
      try {
         // Pega o jogo
         $game = DB::table('game')->where('id', $id)->first();
         if (!$game) {
            return response()->json(['error' => 1, 'message' => 'Jogo não encontrado'], 404);
         }

         // Conta quantos jogadores estão no jogo
         $players = DB::table('game_app_usuario')
            ->where('game_id', $id)
            ->count();

         // Defina a lógica de ir para próximo cenário
         // Por exemplo: se houver pelo menos 1 jogador, pode ir para o próximo
         $isGoNextGame = $players > 0;

         return response()->json(['error' => 0, 'isGoNextGame' => $isGoNextGame, 'players' => $players], 200);
      } catch (Exception $e) {
         return response()->json(['error' => 1, 'message' => $e->getMessage()], 400);
      }
   }

   public function getGame($id)
   {
      try {
         $game = DB::table('game')->whereRaw("id = '{$id}'")->first();
         return response()->json(['error' => 0, 'game' =>  $game], 200);
      } catch (Exception $e) {
         return response()->json(['error' => 1, 'message' =>  $e->getMessage()], 400);
      }
   }

   public function getGameInit($id)
   {
      try {
         $game = DB::table('game')->whereRaw("id = '{$id}'")->first();
         $tema = DB::table('tema')->whereRaw("id = '{$game->tema_id}'")->first();
         $d = new DateTime(__nowDateUtcToDB());
         $d2 = new DateTime(__nowDateUtcToDB());
         // $d2->modify("+{$tema->game_cronometro} minutes");
         DB::table('game')->whereRaw("id = '{$id}' && game_time IS NULL")->update([
            'game_time' => $d->format('Y-m-d H:i:s'),
            'game_time_final' => $d2->format('Y-m-d H:i:s')
         ]);

         $game = DB::table('game')->whereRaw("id = '{$id}'")->first();

         return response()->json(['error' => 0, 'game' =>  $game, 'date_now' => __nowDateUtcToDB()], 200);
      } catch (Exception $e) {
         return response()->json(['error' => 1, 'message' =>  $e->getMessage()], 400);
      }
   }

   public function tema($code)
   {
      try {
         $game = DB::table('game')->whereRaw("sha1(id) = '{$code}'")->first();
         $tema = DB::table('tema AS T')->selectRaw('T.*')->whereRaw("T.id = '{$game->tema_id}'")->first();

         return response()->json(['error' => 0, 'game' =>  $game, 'tema' =>  $tema], 200);
      } catch (Exception $e) {
         return response()->json(['error' => 1, 'message' =>  $e->getMessage()], 400);
      }
   }

   public function playerFinish(Request $request, $id)
   {
      try {
         $user_id = $this->getDecodeToken()['id']; // pega ID do usuário logado
         $totalPoints = $request->input('totalPoints', 0); // pega os pontos do front, default 0

         DB::table('game_app_usuario')
            ->whereRaw("game_id = '{$id}'")
            ->whereRaw("app_usuario_id = ?", [$user_id])
            ->update([
               'status' => 2,
               'total_points' => $totalPoints,
               'finished_at' => now(),
            ]);

         return response()->json([
            'error' => 0,
            'message' => 'Jogador finalizado com sucesso!',
            'status' => 2,
            'total_points' => $totalPoints
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'error' => 1,
            'message' => $e->getMessage()
         ], 400);
      }
   }

   public function gameFinish(Request $request, $id)
   {
      try {
         DB::table('game_app_usuario')
            ->where('game_id', $id)
            ->update([
               'status' => 2
            ]);

         DB::table('game')
            ->where('id', $id)
            ->update([
               'status' => 2,
               'final_game_at' => __nowDateUtcToDB(),
               'game_time_final' => __nowDateUtcToDB()
            ]);

         return response()->json([
            'error' => 0,
            'message' => 'Jogo finalizado com sucesso!',
            'isGoFinishGame' => true
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'error' => 1,
            'message' => $e->getMessage()
         ], 400);
      }
   }

   public function gameUpdate(Request $request)
   {
      try {
         $campo = $request->all()['campo'];
         DB::table('game')->whereRaw("id = ?", [$request->all()['game_id']])->update([
            $campo => $request->all()['value']
         ]);

         return response()->json(['error' => 0, 'message' => 'OK'], 200);
      } catch (Exception $e) {
         return response()->json(['error' => 1, 'message' =>  $e->getMessage()], 400);
      }
   }

   // Codigo Jossana
   public function scenario(Request $request, $id)
   {
      try {
         $game = DB::table('game')->where('id', $id)->first();
         if (!$game) {
            return response()->json(['error' => 1, 'message' => 'Jogo não encontrado'], 404);
         }

         $scenario_id = $request->input('scenario_id', $game->scenario_id);

         $scenario = DB::table('scenarios')
            ->where('id', $scenario_id)
            ->first();

         $options = DB::table('options')
            ->where('scenario_id', $scenario_id)
            ->get();

         return response()->json([
            'error' => 0,
            'message' => 'OK',
            'scenario' => $scenario,
            'options' => $options
         ], 200);
      } catch (Exception $e) {
         return response()->json([
            'error' => 1,
            'message' => $e->getMessage()
         ], 400);
      }
   }

   public function getPlayerStatus($id)
   {
      try {
         $user_id = $this->getDecodeToken()['id'];

         $player = DB::table('game_app_usuario')
            ->where('game_id', $id)
            ->where('app_usuario_id', $user_id)
            ->first();

         if (!$player) {
            return response()->json(['error' => 1, 'message' => 'Jogador não encontrado'], 404);
         }

         return response()->json([
            'error' => 0,
            'status' => $player->status,
            'total_points' => $player->total_points
         ], 200);
      } catch (Exception $e) {
         return response()->json(['error' => 1, 'message' => $e->getMessage()], 400);
      }
   }

   public function ranking($id)
   {
      try {
         $players = DB::table('game_app_usuario')
            ->join('app_usuario', 'app_usuario.id', '=', 'game_app_usuario.app_usuario_id')
            ->select(
               'app_usuario.id',
               'app_usuario.nome as name',
               'game_app_usuario.total_points as score',
               'game_app_usuario.created_at',
               'game_app_usuario.finished_at',
               DB::raw("
                    CASE
                        WHEN game_app_usuario.finished_at IS NULL THEN 99999999
                        ELSE TIMESTAMPDIFF(SECOND, game_app_usuario.created_at, game_app_usuario.finished_at)
                    END AS time_seconds
                ")
            )
            ->where('game_app_usuario.game_id', $id)
            ->orderByRaw("CASE WHEN game_app_usuario.total_points > 0 THEN 0 ELSE 1 END ASC")
            ->orderBy('game_app_usuario.total_points', 'desc')
            ->orderBy('time_seconds', 'asc')
            ->get()
            ->map(function ($player) {

               // Se tempo = 99999999 significa "não finalizou"
               if ($player->time_seconds == 99999999) {
                  $player->time_seconds = null;
                  $player->time_minutes = null;
               } else {
                  $player->time_minutes = round($player->time_seconds / 60, 2);
               }

               return $player;
            });

         return response()->json([
            'error' => 0,
            'ranking' => $players,
         ]);
      } catch (Exception $e) {
         return response()->json([
            'error' => 1,
            'message' => $e->getMessage(),
         ], 400);
      }
   }


   public function storeAnswer(Request $request, $gameId)
   {
      try {
         $user_id = $this->getDecodeToken()['id'];

         $gameUser = DB::table('game_app_usuario')
            ->where('game_id', $gameId)
            ->where('app_usuario_id', $user_id)
            ->first();

         DB::table('game_scenario_answers')->insert([
            'scenarios_id' => $request->scenario_id,
            'options_id' => $request->option_id,
            'game_app_usuario_id' => $gameUser->id,
            'points' => $request->points ?? 0,
         ]);

         return response()->json([
            'error' => 0,
            'message' => 'Resposta salva com sucesso!'
         ], 200);
      } catch (\Exception $e) {
         return response()->json([
            'error' => 1,
            'message' => $e->getMessage()
         ], 400);
      }
   }

   public function graphForGame($gameId)
   {
      try {


         $scenarios = DB::table('scenarios')->get(); // ou filtrar por game, se pertinente

         // Buscando contagens por option (filtrando apenas respostas do game)
         $rows = DB::table('scenarios as s')
            ->leftJoin('options as o', 'o.scenario_id', '=', 's.id')
            ->leftJoin('game_scenario_answers as gsa', 'gsa.options_id', '=', 'o.id')
            ->leftJoin('game_app_usuario as gau', function ($join) use ($gameId) {
               $join->on('gau.id', '=', 'gsa.game_app_usuario_id')
                  ->where('gau.game_id', '=', $gameId);
            })
            ->select(
               's.id as scenario_id',
               's.title as scenario_title',
               'o.id as option_id',
               'o.description as option_description',
               'o.next_scenario_id',
               DB::raw('COUNT(*) as responses_count') //  <-- AQUI ESTÁ A CORREÇÃO
            )
            ->groupBy('s.id', 'o.id', 'o.next_scenario_id', 's.title', 'o.description')
            ->orderBy('s.id')
            ->get();
         // Montar estrutura hierárquica
         $graph = [];
         foreach ($rows as $r) {
            $sid = $r->scenario_id;
            if (!isset($graph[$sid])) {
               $graph[$sid] = [
                  'id' => $sid,
                  'title' => $r->scenario_title,
                  'options' => []
               ];
            }
            // Se option_id for null (cenário sem opções) pule
            if ($r->option_id !== null) {
               $graph[$sid]['options'][] = [
                  'id' => $r->option_id,
                  'text' => $r->option_description,
                  'next_scenario_id' => $r->next_scenario_id,
                  'count' => (int)$r->responses_count
               ];
            }
         }

         // Retornar como array de nós
         $graph = array_values($graph);

         return response()->json([
            'error' => 0,
            'game_id' => $gameId,
            'graph' => $graph
         ], 200);
      } catch (\Exception $e) {
         return response()->json(['error' => 1, 'message' => $e->getMessage()], 500);
      }
   }
}
