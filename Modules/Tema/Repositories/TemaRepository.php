<?php

namespace Modules\Tema\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\Admin\Repositories\RepositoryInterface;

/**
 * Class PeriodoRepository
 * @package Modules\Cadastro\Repositories
 */
class TemaRepository extends AbstractRepository implements RepositoryInterface
{

   /**
    * @var string
    */
   protected $table = "tema";
   protected $fillable = ["idioma", "titulo", "texto_erro_geral", "texto_msg_final", "logo_img", "marca_img", "fundo_img", "fundo_cor", "cor_fonte", "bg_btn_cor", "text_ranking", "select_option_cor"];
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
      $select = DB::table('tema AS T')
         ->selectRaw("T.*");

      if ($query_params['search']['id'] > 0) {
         $select->where(['I.id' => (int)$query_params['search']['id']]);
      }

      if (!empty($query_params['search']['titulo'])) {
         $select->where('I.titulo', 'LIKE', "%{$query_params['search']['titulo']}%");
      }

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
         $data[] = ['DT_RowId' => $row->id, $row->id, $row->titulo, $row->idioma];
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
