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
         $user_id = $this->getDecodeToken()['id'];
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

         //pegar pergunta quando sair do jogo e entrar de novo
         $gameUser = DB::table('game_app_usuario')
            ->where('game_id', $id)
            ->where('app_usuario_id', $user_id)
            ->first();

         $game->current_scenario_id = $gameUser->current_scenario_id ?? null;


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
         $user_id = $this->getDecodeToken()['id'];

         $gameUser = DB::table('game_app_usuario')
            ->where('game_id', $id)
            ->where('app_usuario_id', $user_id)
            ->first();

         $totalPoints = DB::table('game_scenario_answers')
            ->where('game_app_usuario_id', $gameUser->id)
            ->sum('points');

         DB::table('game_app_usuario')
            ->where('id', $gameUser->id)
            ->update([
               'status' => 2,
               'total_points' => $totalPoints,
               'finished_at' => __nowDateUtcToDB(),
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

   private function normalizeCode(?string $code): string
   {
      if ($code === null) {
         return '';
      }

      $code = trim($code);

      // Minúsculas respeitando Unicode
      $code = mb_strtolower($code, 'UTF-8');

      // Remove acentos/diacríticos
      if (class_exists(\Normalizer::class)) {
         $code = \Normalizer::normalize($code, \Normalizer::FORM_D);
         $code = preg_replace('/\p{Mn}/u', '', $code);
      }

      // Remove espaços extras
      $code = preg_replace('/\s+/u', ' ', $code);

      return trim($code);
   }

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
            ->select([
               'id',
               'title',
               'description',
               'points',
               'scenario_id',
               'next_scenario_id',
               'is_message',
               DB::raw("CASE
         WHEN code IS NOT NULL AND TRIM(code) <> '' THEN 1
         ELSE 0
      END AS requires_code")
            ])
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

         if (!$gameUser) {
            return response()->json([
               'error' => 1,
               'message' => 'Jogador não encontrado neste jogo.'
            ], 404);
         }

         /*
       * =====================================================
       * 3. VALIDA O CENÁRIO
       * =====================================================
       */
         $scenarioId = $request->input('scenario_id');

         if (!$scenarioId) {
            return response()->json([
               'error' => 1,
               'message' => 'Cenário não informado.'
            ], 422);
         }

         /*
       * =====================================================
       * 4. BUSCA O CENÁRIO
       * =====================================================
       */
         $scenario = DB::table('scenarios')
            ->where('id', $scenarioId)
            ->first();

         if (!$scenario) {
            return response()->json([
               'error' => 1,
               'message' => 'Cenário não encontrado.'
            ], 404);
         }

         /*
       * =====================================================
       * 5. CENÁRIO FINAL
       * =====================================================
       *
       * No cenário final o Front envia:
       *
       * option_id = null
       *
       * Portanto não devemos exigir uma opção.
       *
       * Finalizamos o jogador diretamente aqui.
       */
         if ((int) $scenario->is_finally === 1) {

            $totalPoints = DB::table('game_scenario_answers')
               ->where('game_app_usuario_id', $gameUser->id)
               ->sum('points');

            DB::table('game_app_usuario')
               ->where('id', $gameUser->id)
               ->update([
                  'status' => 2,
                  'total_points' => $totalPoints,
                  'finished_at' => __nowDateUtcToDB(),
                  'current_scenario_id' => $scenarioId
               ]);

            return response()->json([
               'error' => 0,
               'message' => 'Jogador finalizado com sucesso!',
               'status' => 2,
               'total_points' => $totalPoints,
               'finished_at' => __nowDateUtcToDB(),
               'next_scenario_id' => null
            ], 200);
         }

         /*
       * =====================================================
       * 6. PARA CENÁRIO NORMAL, OPÇÃO É OBRIGATÓRIA
       * =====================================================
       */
         $optionId = $request->input('option_id');

         if (!$optionId) {
            return response()->json([
               'error' => 1,
               'message' => 'Opção não informada.'
            ], 422);
         }

         /*
       * =====================================================
       * 7. BUSCA A OPÇÃO
       * =====================================================
       *
       * A opção precisa pertencer ao cenário informado.
       */
         $option = DB::table('options')
            ->where('id', $optionId)
            ->where('scenario_id', $scenarioId)
            ->first();

         if (!$option) {
            return response()->json([
               'error' => 1,
               'message' => 'Opção inválida.'
            ], 422);
         }

         /*
       * =====================================================
       * 8. OPÇÃO COM CÓDIGO
       * =====================================================
       *
       * O código é comparado no BACKEND.
       *
       * Ignora:
       * - maiúsculas/minúsculas
       * - acentos
       * - espaços no início/fim
       *
       * Exemplo:
       *
       * Banco: CáSÃ
       *
       * Aceita:
       * CASA
       * casa
       * Casa
       * CáSÃ
       * cAsA
       * cáSa
       */
         if (!empty(trim($option->code ?? ''))) {

            $inputCode = $this->normalizeCode(
               $request->input('code')
            );

            $correctCode = $this->normalizeCode(
               $option->code
            );

            if ($inputCode === '') {
               return response()->json([
                  'error' => 1,
                  'message' => 'Código obrigatório.'
               ], 422);
            }

            if ($inputCode !== $correctCode) {
               return response()->json([
                  'error' => 1,
                  'message' => 'Código incorreto.'
               ], 422);
            }
         }

         /*
       * =====================================================
       * 9. OPÇÃO COM MENSAGEM
       * =====================================================
       */
         $message = null;

         if ((int) $option->is_message === 1) {

            $message = trim(
               (string) $request->input('message', '')
            );

            if ($message === '') {
               return response()->json([
                  'error' => 1,
                  'message' => 'Mensagem obrigatória.'
               ], 422);
            }
         }

         /*
       * =====================================================
       * 10. PONTOS
       * =====================================================
       *
       * Os pontos vêm SEMPRE do banco.
       */
         $points = (int) ($option->points ?? 0);

         /*
       * =====================================================
       * 11. SALVA A RESPOSTA
       * =====================================================
       */
         DB::table('game_scenario_answers')->insert([
            'scenarios_id' => $scenarioId,
            'options_id' => $option->id,
            'game_app_usuario_id' => $gameUser->id,
            'points' => $points,
            'message' => $message,
         ]);

         /*
       * =====================================================
       * 12. RECALCULA TOTAL DE PONTOS
       * =====================================================
       */
         $totalPoints = DB::table('game_scenario_answers')
            ->where('game_app_usuario_id', $gameUser->id)
            ->sum('points');

         /*
       * =====================================================
       * 13. PRÓXIMO CENÁRIO
       * =====================================================
       */
         $nextScenarioId = $option->next_scenario_id;

         DB::table('game_app_usuario')
            ->where('id', $gameUser->id)
            ->update([
               'current_scenario_id' => $nextScenarioId,
               'total_points' => $totalPoints
            ]);

         /*
       * =====================================================
       * 14. RETORNO
       * =====================================================
       */
         return response()->json([
            'error' => 0,
            'message' => 'Resposta salva com sucesso!',
            'points' => $points,
            'total_points' => $totalPoints,
            'next_scenario_id' => $nextScenarioId
         ], 200);
      } catch (\Exception $e) {

         Log::error('Erro ao salvar resposta do jogo', [
            'game_id' => $gameId,
            'user_id' => $this->getDecodeToken()['id'] ?? null,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
         ]);

         return response()->json([
            'error' => 1,
            'message' => 'Erro ao salvar resposta.'
         ], 500);
      }
   }




   // public function storeAnswer(Request $request, $gameId)
   // {
   //    try {
   //       $user_id = $this->getDecodeToken()['id'];

   //       $gameUser = DB::table('game_app_usuario')
   //          ->where('game_id', $gameId)
   //          ->where('app_usuario_id', $user_id)
   //          ->first();

   //       DB::table('game_scenario_answers')->insert([
   //          'scenarios_id' => $request->scenario_id,
   //          'options_id' => $request->option_id ?? null,
   //          'game_app_usuario_id' => $gameUser->id,
   //          'points' => $request->points ?? 0,
   //          'message' => $request->message ?? null,
   //       ]);

   //       $totalPoints = DB::table('game_scenario_answers')
   //          ->where('game_app_usuario_id', $gameUser->id)
   //          ->sum('points');

   //       if ($request->option_id) {
   //          $option = DB::table('options')
   //             ->where('id', $request->option_id)
   //             ->where('scenario_id', $request->scenario_id)
   //             ->first();

   //          DB::table('game_app_usuario')
   //             ->where('id', $gameUser->id)
   //             ->update([
   //                'current_scenario_id' => $option->next_scenario_id,
   //                'total_points' => $totalPoints
   //             ]);
   //       } else {
   //          DB::table('game_app_usuario')
   //             ->where('id', $gameUser->id)
   //             ->update([
   //                'total_points' => $totalPoints
   //             ]);
   //       }

   //       return response()->json([
   //          'error' => 0,
   //          'message' => 'Resposta salva com sucesso!'
   //       ], 200);
   //    } catch (\Exception $e) {
   //       return response()->json([
   //          'error' => 1,
   //          'message' => $e->getMessage()
   //       ], 400);
   //    }
   // }

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

   public function ranking(Request $request, $id)
   {
      try {
         $game = DB::table('game')->where('id', $id)->first();

         if (!$game) {
            return response()->json([
               'error' => 1,
               'message' => 'Jogo não encontrado'
            ], 404);
         }

         $type = (int) $request->query('type', 1);

         $cacheKey = $type === 2 && $game->agrupador_id
            ? "ranking_agrupamento_{$game->agrupador_id}"
            : "ranking_game_{$id}";

         $ranking = Cache::remember($cacheKey, 30, function () use ($type, $game, $id) {

            $query =  DB::table('game_app_usuario', 'GAU')
               ->join(
                  'app_usuario AS AU',
                  'GAU.app_usuario_id',
                  '=',
                  'AU.id'
               )
               ->join('game as G', 'G.id', '=', 'GAU.game_id')
               ->selectRaw('AU.email,AU.nome, SUM(GAU.total_points) as score')
               ->selectRaw("SUM(
                                 TIMESTAMPDIFF(
                                    SECOND,
                                    GAU.created_at,
                                    COALESCE(GAU.finished_at, NOW())
                                 )
                              ) AS time_seconds
                           ")
               ->groupBy('AU.id')
               ->orderByRaw('score DESC, time_seconds ASC');

            if ($type === 2) {
               $query->where('G.agrupador_id', $game->agrupador_id);
            } else {
               $query->where('GAU.game_id', '=', $id);
            }

            $data = $query->get();

            return $data;
         });

         return response()->json([
            'success' => true,
            'ranking' => $ranking,
         ]);
      } catch (\Exception $e) {
         return response()->json([
            'error' => 1,
            'message' => $e->getMessage(),
         ], 400);
      }
   }


   public function rankingUnit($id)
   {
      try {

         $user_id = $this->getDecodeToken()['id'];

         $player = DB::table('game_app_usuario')
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
                  WHEN game_app_usuario.finished_at IS NULL THEN NULL
                  ELSE TIMESTAMPDIFF(
                     SECOND,
                     game_app_usuario.created_at,
                     game_app_usuario.finished_at
                  )
               END AS time_seconds
            ")
            )
            ->where('game_app_usuario.game_id', $id)
            ->where('game_app_usuario.app_usuario_id', $user_id)
            ->first();

         if (!$player) {
            return response()->json([
               'error' => 1,
               'message' => 'Jogador não encontrado'
            ], 404);
         }

         return response()->json([
            'error' => 0,
            'player' => $player
         ]);
      } catch (\Exception $e) {
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
