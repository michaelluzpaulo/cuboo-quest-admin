<?php

namespace Modules\Dica\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Modules\Dica\Repositories\DicaRepository;

class DicaService
{

   /**
    * @var DicaRepository
    */
   private $repository;

   /**
    * Periodoervice constructor.
    * @param DicaRepository $repository
    */
   public function __construct(DicaRepository $repository)
   {
      $this->repository = $repository;
   }

   public function index()
   {
      $temas = DB::table('tema')->orderBy('titulo')->get();
      return view('dica::index', ['temas' => $temas]);
   }

   public function isValidate($arr)
   {

      return $v = Validator::make($arr, [
         'intent' => 'required|min:2|max:255',
      ]);
   }


   public function save($id = 0, $data)
   {

      $v = $this->isValidate($data);
      if ($v->fails()) {
         return __format_error_html($v);
      }

      try {

         if ($id) {
            $obj = $this->repository->find($id);
         } else {
            $obj = $this->repository;
         }

         DB::beginTransaction();
         $obj->fill($data);
         $obj->save();

         DB::delete('DELETE FROM dica_intent WHERE dica_id = ?', [$obj->id]);
         $arrIntent = explode(';', $data['intent']);
         foreach ($arrIntent as $intent) {
            $intentBF = trim($intent);
            DB::insert('INSERT INTO dica_intent (dica_id, intent, tipo) VALUES (?, ?, ?)', [
               $obj->id, $intentBF, 1
            ]);
         }

         DB::commit();
         return response()->json(['error' => 0, 'message' => 'O registro foi salvo com sucesso.', 'data' => ['id' => $obj->id]], 200);
      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 400);
      }
   }

   public function create()
   {
      $temas = DB::table('tema')->get();
      return view('dica::create', ['temas' => $temas]);
   }

   public function edit($id)
   {
      $temas = DB::table('tema')->get();
      $dica = $this->repository->find($id);
      return view('dica::edit', ['dica' => $dica, 'temas' => $temas]);
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
         $search['tema'] = (int)$search['tema'];
         $search['titulo'] = filter_var($search['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

         switch ((int)$order[0]['column']) {
            case 0:
               $sort = 'id';
               break;
            case 1:
               $sort = 'intent';
               break;
            case 2:
               $sort = 'TEMA';
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
