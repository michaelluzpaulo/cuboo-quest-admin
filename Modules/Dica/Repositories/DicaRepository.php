<?php

namespace Modules\Dica\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\Admin\Repositories\RepositoryInterface;

/**
 * Class PeriodoRepository
 * @package Modules\Cadastro\Repositories
 */
class DicaRepository extends AbstractRepository implements RepositoryInterface
{

   /**
    * @var string
    */
   protected $table = "dica";
   protected $fillable = ['tema_id', 'texto', 'intent'];
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
      $select = DB::table('dica AS D')
         ->selectRaw("D.*,T.titulo AS TEMA,T.idioma")
         ->join('tema AS T', 'D.tema_id', '=', 'T.id');

      if ($query_params['search']['id'] > 0) {
         $select->where(['D.id' => (int)$query_params['search']['id']]);
      }
      if ($query_params['search']['tema'] > 0) {
         $select->where(['D.tema_id' => (int)$query_params['search']['tema']]);
      }

      if (!empty($query_params['search']['titulo'])) {
         $select->whereRaw("(D.intent LIKE '%{$query_params['search']['titulo']}%' || D.texto LIKE '%{$query_params['search']['titulo']}%')");
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
         $data[] = ['DT_RowId' => $row->id, $row->id, $row->intent, $row->TEMA . " ({$row->idioma})"];
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
