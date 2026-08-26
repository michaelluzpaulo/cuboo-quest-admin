<?php

namespace Modules\Scenario\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Modules\Scenario\Repositories\ScenarioRepository;

class ScenarioService
{

   /**
    * @var ScenarioRepository
    */
   private $repository;

   /**
    * Periodoervice constructor.
    * @param ScenarioRepository $repository
    */
   public function __construct(ScenarioRepository $repository)
   {
      $this->repository = $repository;
   }

   public function index()
   {
      $scenarios = DB::table('scenarios')
         ->whereRaw("root_scenario_id IS NULL")
         ->get();
      $idiomas = DB::table('idioma')->pluck('sigla');
      return view('scenario::index', ['idiomas' => $idiomas, 'scenarios' => $scenarios]);
   }

   public function isValidate($arr)
   {

      return $v = Validator::make($arr, [
         'title' => 'required|min:2|max:255',
         // 'intent' => 'required|min:2|max:255',
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

         if (empty($data['root_scenario_id']) || $data['root_scenario_id'] == 0) {
            $data['root_scenario_id'] = null;
         }

         DB::beginTransaction();
         $obj->fill($data);
         $obj->save();


         DB::commit();
         return response()->json(['error' => 0, 'message' => 'O registro foi salvo com sucesso.', 'data' => ['id' => $obj->id]], 200);
      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 400);
      }
   }

   public function create()
   {
      $idiomas = DB::table('idioma')->pluck('sigla');
      $rootScenarios = DB::table('scenarios')
         ->whereRaw("root_scenario_id IS NULL")
         ->get();

      return view('scenario::create', ['idiomas' => $idiomas, 'rootScenarios' => $rootScenarios]);
   }

   public function edit($id)
   {
      $scenario = $this->repository->find($id);
      $idiomas = DB::table('idioma')->get();
      $rootScenarios = DB::table('scenarios')
         ->whereRaw("root_scenario_id IS NULL && id != ?", [$id])
         ->get();

      $options = DB::table('options')
         ->where('scenario_id', $id)
         ->get();


      return view('scenario::edit', ['scenario' => $scenario, 'idiomas' => $idiomas, 'rootScenarios' => $rootScenarios, 'options' => $options]);
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
         $search['title'] = filter_var($search['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

         switch ((int)$order[0]['column']) {
            case 0:
               $sort = 'id';
               break;
            case 1:
               $sort = 'title';
               break;
            case 2:
               $sort = 'root_scenario_id';
               break;
            case 2:
               $sort = 'is_finally';
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
