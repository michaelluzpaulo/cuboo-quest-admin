<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth:api', ['except' => ['login', 'register']]);
   }

   public function login(Request $request)
   {
      $request->validate([
         'email' => 'required|string|email',
         'nome' => 'required|string',
      ]);

      try {
         $user_id = 0;
         $userBF = DB::table('app_usuario')->where('email', '=', $request->email)->first();
         $game = DB::table('game')->where('id', '=', $request->game_id)->first();

         if ($game->ativo == 'N') {
            throw new Exception('Game not active! ');
         }

         if ($game->date_expiracao) {
            $d1 = new \DateTime(__nowDateUtcToDB());
            $d2 = new \DateTime($game->date_expiracao . ' 23:59:59');
            if ($d1 > $d2) {
               throw new Exception('Game expired! ');
            }
         }

         if ($userBF) {
            $user_id = $userBF->id;
         } else {
            $user_id = DB::table('app_usuario')->insertGetId(['nome' => $request->nome, 'email' => $request->email, 'ativo' => 'S', 'password' => Hash::make('123456')]);
         }

         $gameAppUsuario = DB::table('game_app_usuario')
         ->where('game_id', '=', $request->game_id)
         ->where('app_usuario_id', '=', $user_id)
         ->first();

        if (!$gameAppUsuario) {
            DB::table('game_app_usuario')->insert([
                'game_id' => $request->game_id,
                'app_usuario_id' => $user_id,
                'created_at' => __nowDateUtcToDB()
            ]);

            $gameAppUsuario = DB::table('game_app_usuario')
                ->where('game_id', '=', $request->game_id)
                ->where('app_usuario_id', '=', $user_id)
                ->first();
        }

         $data = ['email' => $request->email, 'password' => "123456", 'ativo' => "S"];
         $token = Auth::guard('api')->attempt($data);
         // $token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => "123456", 'ativo' => "S"]);
         // if (!$token) {
         //   throw new Exception('Invalid credentials');
         // }

         $user = Auth::guard('api')->user();

         return response()->json([
            'status' => 'success',
            'user' => $user,
            'game_sala' => $gameAppUsuario,
            'authorization' => [
               'token' => $token,
               'type' => 'bearer',
            ]
         ]);
      } catch (Exception $e) {

         return response()->json([
            'error' => 1,
            'status' => 'error',
            'message' => $e->getMessage(),
         ], 400);
      }
   }

   public function register(Request $request)
   {
      $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|string|email|max:255|unique:users',
         'password' => 'required|string|min:6',
      ]);

      $user = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request->password),
      ]);

      return response()->json([
         'message' => 'User created successfully',
         'user' => $user
      ]);
   }

   public function logout()
   {
      Auth::logout();
      return response()->json([
         'message' => 'Successfully logged out',
      ]);
   }

   public function refresh()
   {
      // return response()->json([
      //   'user' => Auth::user(),
      //   'authorisation' => [
      //     'token' => Auth::refresh(),
      //     'type' => 'bearer',
      //   ]
      // ]);

      return response()->json([
         'status' => 'success',
         'user' => Auth::guard('api')->user(),
         'authorisation' => [
            'token' => Auth::guard('api')->refresh(),
            'type' => 'bearer',
         ]
      ]);
   }
}
