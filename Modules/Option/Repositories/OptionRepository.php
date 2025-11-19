<?php

namespace Modules\Option\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\Admin\Repositories\RepositoryInterface;

/**
 * Class PeriodoRepository
 * @package Modules\Cadastro\Repositories
 */
class OptionRepository extends AbstractRepository implements RepositoryInterface
{

   /**
    * @var string
    */
   protected $table = "options";
   protected $fillable = ['title', 'description', 'points', 'scenario_id', 'next_scenario_id'];
   //protected $guarded = ['id'];
   public $timestamps = false;


   /**
    * @param array $query_params
    * @return array
    */
   public function findAll(array $query_params): array
   {
      $params = [];

      // Carrega os registro conforme filtros aplicados.

      $select = DB::table('options AS D')
         ->leftJoin('scenarios AS S', 'D.next_scenario_id', '=', 'S.id')
         ->select(
            'D.id',
            'D.title',
            'D.points',
            'D.next_scenario_id',
            'S.title AS next_scenario_title'
         )
         ->where('D.scenario_id', (int) $query_params['search']['scenario_id']);

      // $select->where(['D.scenario_id' => (int)$query_params["search"]['scenario_id']]);

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
            $row->points,
            $row->next_scenario_title,
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
