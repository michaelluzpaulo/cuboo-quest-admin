<?php

namespace Modules\Option\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Modules\Option\Repositories\OptionRepository;

class OptionService
{
   /**
    * @var OptionRepository
    */
   private $repository;

   /**
    * Periodoervice constructor.
    * @param OptionRepository $repository
    */
   public function __construct(OptionRepository $repository)
   {
      $this->repository = $repository;
   }

   // public function index()
   // {
   //    $idiomas = DB::table('idioma')->pluck('sigla');
   //    return view('option::index', ['idiomas' => $idiomas]);
   // }

   public function isValidate($arr)
   {

      return $v = Validator::make($arr, [
         'title' => 'required|min:2|max:255',
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

         $obj->fill($data);
         $obj->save();

         return response()->json(['error' => 0, 'message' => 'O registro foi salvo com sucesso.', 'data' => ['id' => $obj->id]], 200);
      } catch (\Exception $e) {
         return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 400);
      }
   }

   public function create($scenario_id)
   {
      $scenario = DB::table('scenarios')->whereRaw("id = ?", [$scenario_id])->first();
      $root_scenario_id = $scenario->root_scenario_id ?: $scenario_id;
      $nextScenarios = DB::table('scenarios')
         ->whereRaw("root_scenario_id = ?", [$root_scenario_id])
         ->whereRaw("id != ?", [$scenario_id])
         ->orderBy("id")
         ->get();

      return view('option::create', ['scenario_id' => $scenario_id, 'nextScenarios' => $nextScenarios]);
   }

   public function edit($scenario_id, $id)
   {
      $option = $this->repository
         ->where('scenario_id', $scenario_id)
         ->find($id);

      $scenario = DB::table('scenarios')->whereRaw("id = ?", [$scenario_id])->first();
      $root_scenario_id = $scenario->root_scenario_id ?: $scenario_id;
      $nextScenarios = DB::table('scenarios')
         ->whereRaw("root_scenario_id = ?", [$root_scenario_id])
         ->whereRaw("id != ?", [$scenario_id])
         ->orderBy("id")
         ->get();


      return view('option::edit', ['option' => $option, 'scenario_id' => $scenario_id, 'nextScenarios' => $nextScenarios,]);
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
   public function findAll(array $param)
   {
      try {
         $order = $param['order'];
         $search = $param['search'];

         switch ((int)$order[0]['column']) {
            case 0:
               $sort = 'id';
               break;
            case 1:
               $sort = 'title';
               break;
            case 2:
               $sort = 'points';
               break;
            case 3:
               $sort = 'next_scenario_title';
               break;
         }

         $start = (int) $param['start'];
         $limit = (int) $param['length'];

         $query_params = [
            'start' => $start,
            'limit' => $limit,
            'sort' => $sort,
            'dir' => $order[0]['dir'],
            'search' => $search,
         ];

         $result = $this->repository->findAll($query_params);

         $draw = (int) $param['draw'];

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
