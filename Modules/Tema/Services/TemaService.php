<?php

namespace Modules\Tema\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Dica\Repositories\DicaRepository;
use Validator;
use Modules\Tema\Repositories\TemaRepository;

class TemaService
{

   /**
    * @var TemaRepository
    */
   private $repository;
   private $dicaRepository;

   /**
    * Periodoervice constructor.
    * @param TemaRepository $repository
    */
   public function __construct(TemaRepository $repository, DicaRepository $dicaRepository)
   {
      $this->repository = $repository;
      $this->dicaRepository = $dicaRepository;
   }

   public function isValidate($arr)
   {

      return $v = Validator::make($arr, [
         'titulo' => 'required|min:2|max:70',
      ]);
   }


   public function save($id = 0, $data)
   {
      try {
         DB::beginTransaction();

         $v = $this->isValidate($data);
         if ($v->fails()) {
            return __format_error_html($v);
         }

         if ($id) {
            $obj = $this->repository->find($id);
         } else {
            $obj = $this->repository;
         }

         $obj->fill($data);
         $obj->save();

         // DB::delete('DELETE FROM tema_intent WHERE tema_id = ?', [$obj->id]);

         DB::commit();
         return response()->json(['error' => 0, 'message' => 'O registro foi salvo com sucesso.', 'data' => ['id' => $obj->id]], 200);
      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 200);
      }
   }

   public function create()
   {
      $idiomas = DB::table('idioma')->get();
      return view('tema::create', ['idiomas' => $idiomas]);
   }

   public function edit($id)
   {
      $idiomas = DB::table('idioma')->get();
      $tema = $this->repository->find($id);
      return view('tema::edit', ['tema' => $tema, 'idiomas' => $idiomas]);
   }

   public function destroy($id)
   {
      $obj = $this->repository->find($id);
      $obj->delete();
      return response()->json(['error' => 0, 'message' => 'O registro foi removido com sucesso.', 'data' => []], 200);
   }

   public function cloneTema($id)
   {
      try {
         DB::beginTransaction();
         $obj = $this->repository->find($id);
         $temaNew = $obj->replicate();
         $temaNew->titulo = $temaNew->titulo . ' - Cópia';
         $temaNew->save();

         // $temaIntents = DB::table('tema_intent')->where('tema_id', $id)->get();
         // foreach ($temaIntents as $temaIntent) {
         //    DB::insert('INSERT INTO tema_intent (tema_id, intent, tipo) VALUES (?, ?, ?)', [
         //       $temaNew->id,
         //       $temaIntent->intent,
         //       $temaIntent->tipo
         //    ]);
         // }


         DB::commit();
         return response()->json(['error' => 0, 'message' => 'O registro foi clonado com sucesso.', 'data' => ['id' => $temaNew->id]], 200);
      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 400);
      }
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
         $search['titulo'] = filter_var($search['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

         switch ((int)$order[0]['column']) {
            case 0:
               $sort = 'id';
               break;
            case 1:
               $sort = 'titulo';
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
