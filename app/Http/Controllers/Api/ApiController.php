<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth; //use this library
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth:api', ['except' => [
         'login',
         'register',
         'tema',
         'mestre',
         'ranking',
      ]]);
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
         $game->token_game = sha1($id);

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

         // codigo para cache INICIO
         $game = DB::table('game')
            ->where('id', $id)
            ->first();

         if (!empty($game->agrupador_id)) {
            Cache::forget("ranking_agrupador_{$game->agrupador_id}");
         } else {
            Cache::forget("ranking_game_{$id}");
         }
         // codigo para cache FIM

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
            'options_id' => $request->option_id ?? null,
            'game_app_usuario_id' => $gameUser->id,
            'points' => $request->points ?? 0,
            'message' => $request->message ?? null,
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


   // public function ranking($id)
   // {
   //    try {

   //       $game = DB::table('game')
   //          ->where('id', $id)
   //          ->first();

   //       if (!$game) {
   //          return response()->json([
   //             'error' => 1,
   //             'message' => 'Jogo não encontrado'
   //          ], 404);
   //       }

   //       // Por padrão considera apenas o jogo atual
   //       $gameIds = collect([$id]);

   //       // Se existir agrupador, busca todos os jogos do agrupador
   //       if (!empty($game->agrupador_id)) {
   //          $gameIds = DB::table('game')
   //             ->where('agrupador_id', $game->agrupador_id)
   //             ->pluck('id');
   //       }

   //       $players = DB::table('game_app_usuario')
   //          ->join(
   //             'app_usuario',
   //             'app_usuario.id',
   //             '=',
   //             'game_app_usuario.app_usuario_id'
   //          )
   //          ->select(
   //             'app_usuario.id',
   //             'app_usuario.nome as name',
   //             'game_app_usuario.total_points as score',
   //             'game_app_usuario.created_at',
   //             'game_app_usuario.finished_at',
   //             DB::raw("
   //             CASE
   //                WHEN game_app_usuario.finished_at IS NULL THEN 99999999
   //                ELSE TIMESTAMPDIFF(
   //                   SECOND,
   //                   game_app_usuario.created_at,
   //                   game_app_usuario.finished_at
   //                )
   //             END AS time_seconds
   //          ")
   //          )
   //          ->whereIn('game_app_usuario.game_id', $gameIds)
   //          ->orderByRaw("
   //          CASE
   //             WHEN game_app_usuario.total_points > 0 THEN 0
   //             ELSE 1
   //          END ASC
   //       ")
   //          ->orderBy('game_app_usuario.total_points', 'desc')
   //          ->orderBy('time_seconds', 'asc')
   //          ->get()
   //          ->map(function ($player) {

   //             if ($player->time_seconds == 99999999) {
   //                $player->time_seconds = null;
   //                $player->time_minutes = null;
   //             } else {
   //                $player->time_minutes = round(
   //                   $player->time_seconds / 60,
   //                   2
   //                );
   //             }

   //             return $player;
   //          });

   //       return response()->json([
   //          'error' => 0,
   //          'ranking' => $players,
   //       ]);
   //    } catch (Exception $e) {

   //       return response()->json([
   //          'error' => 1,
   //          'message' => $e->getMessage(),
   //       ], 400);
   //    }
   // }

   public function ranking($id)
   {
      try {

         $game = DB::table('game')
            ->where('id', $id)
            ->first();

         if (!$game) {
            return response()->json([
               'error' => 1,
               'message' => 'Jogo não encontrado'
            ], 404);
         }

         $cacheKey = !empty($game->agrupador_id)
            ? "ranking_agrupador_{$game->agrupador_id}"
            : "ranking_game_{$id}";

         $players = Cache::remember($cacheKey, 60, function () use ($game, $id) {

            $gameIds = collect([$id]);

            if (!empty($game->agrupador_id)) {
               $gameIds = DB::table('game')
                  ->where('agrupador_id', $game->agrupador_id)
                  ->pluck('id');
            }

            return DB::table('game_app_usuario')
               ->join(
                  'app_usuario',
                  'app_usuario.id',
                  '=',
                  'game_app_usuario.app_usuario_id'
               )
               ->select(
                  'app_usuario.id',
                  'app_usuario.nome as name',
                  'game_app_usuario.total_points as score',
                  'game_app_usuario.created_at',
                  'game_app_usuario.finished_at',
                  DB::raw("
                  CASE
                     WHEN game_app_usuario.finished_at IS NULL THEN 99999999
                     ELSE TIMESTAMPDIFF(
                        SECOND,
                        game_app_usuario.created_at,
                        game_app_usuario.finished_at
                     )
                  END AS time_seconds
               ")
               )
               ->whereIn('game_app_usuario.game_id', $gameIds)
               ->orderByRaw("
               CASE
                  WHEN game_app_usuario.total_points > 0 THEN 0
                  ELSE 1
               END ASC
            ")
               ->orderBy('game_app_usuario.total_points', 'desc')
               ->orderBy('time_seconds', 'asc')
               ->get()
               ->map(function ($player) {

                  if ($player->time_seconds == 99999999) {
                     $player->time_seconds = null;
                     $player->time_minutes = null;
                  } else {
                     $player->time_minutes = round(
                        $player->time_seconds / 60,
                        2
                     );
                  }

                  return $player;
               });
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







   public function mestre($id)
   {
      ini_set('memory_limit', '512M');
      try {
         $game = DB::table('game')->where('id', $id)->first();

         $gameUsuariosIds = DB::table('game_app_usuario')
            ->where('game_id', $game->id)
            ->pluck('id');

         $scenariosBF = DB::table('scenarios')
            ->whereRaw("(id=? OR root_scenario_id=?)", [$game->scenario_id, $game->scenario_id])
            ->orderBy('root_scenario_id')
            ->get();

         $scenariosCache = [];
         foreach ($scenariosBF as $sc) {
            $scenariosCache[$sc->id] = $sc;
         }

         $scenarios = [];

         $this->recursiveScenarios($scenariosCache, $game->scenario_id, $scenarios, $gameUsuariosIds);

         return response()->json([
            'error' => 0,
            'scenarios' => $scenarios
         ]);
      } catch (Exception $e) {
         return response()->json([
            'error' => 1,
            'message' => $e->getMessage()
         ], 400);
      }
   }

   private function recursiveScenarios($scenariosCache, $id, &$scenarios, $gameUsuariosIds, $level = 0, &$addedIds = [])
   {
      // Se já foi adicionado, não processa de novo
      if (in_array($id, $addedIds)) {
         return;
      }

      $sc = $scenariosCache[$id] ?? null;
      if (!$sc) return;

      $options = DB::table('options')
         ->where('scenario_id', $id)
         ->get();

      $totalRespostas = DB::table('game_scenario_answers')
         ->where('scenarios_id', $id)
         ->whereIn('options_id', $options->pluck('id'))
         ->whereIn('game_app_usuario_id', $gameUsuariosIds)
         ->count();

      foreach ($options as $op) {
         $op->totalSelected = DB::table('game_scenario_answers')
            ->where('scenarios_id', $id)
            ->where('options_id', $op->id)
            ->whereIn('game_app_usuario_id', $gameUsuariosIds)
            ->count();

         $op->percent = $totalRespostas > 0 ? ($op->totalSelected / $totalRespostas) * 100 : 0;
      }

      $sc->options = $options;
      $sc->level = $level;
      $scenarios[] = $sc;

      // Marca como adicionado
      $addedIds[] = $id;

      foreach ($options as $op) {
         if (!empty($op->next_scenario_id)) {
            $this->recursiveScenarios(
               $scenariosCache,
               $op->next_scenario_id,
               $scenarios,
               $gameUsuariosIds,
               $level + 1,
               $addedIds
            );
         }
      }
   }
}
