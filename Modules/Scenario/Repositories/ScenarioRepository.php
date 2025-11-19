<?php

namespace Modules\Scenario\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\Admin\Repositories\RepositoryInterface;

/**
 * Class PeriodoRepository
 * @package Modules\Cadastro\Repositories
 */
class ScenarioRepository extends AbstractRepository implements RepositoryInterface
{

   /**
    * @var string
    */
   protected $table = "scenarios";
   protected $fillable = ['title', 'description', 'created_at', 'updated_at', 'is_finally', 'root_scenario_id', 'sigla'];
   //protected $guarded = ['id'];
   public $timestamps = true;


   /**
    * @param array $query_params
    * @return array
    */
   public function findAll(array $query_params): array
   {
      $params = [];

      // Carrega os registro conforme filtros aplicados.
      $select = DB::table('scenarios AS D')
         ->select('D.*');

      if ($query_params['search']['id'] > 0) {
         $select->where(['D.id' => (int)$query_params['search']['id']]);
      }

      if ($query_params['search']['scenarios']) {
         $select->whereRaw("D.id = ? || D.root_scenario_id = ? ", [
            $query_params['search']['scenarios'],
            $query_params['search']['scenarios'],
         ]);
      }

      if (!empty($query_params['search']['title'])) {
         $select->whereRaw("(D.title LIKE '%{$query_params['search']['title']}%' )");
      }

      $select->groupByRaw("D.id");

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


      foreach ($result as $row) {
         $data[] = [
            'DT_RowId' =>
            $row->id,
            $row->id,
            $row->title,
            $row->root_scenario_id === null ? 'S' : 'N',
            $row->is_finally == 0 ? 'N' : 'S',
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
