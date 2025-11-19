<?php

namespace Modules\AppUsuario\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\Admin\Repositories\RepositoryInterface;

/**
 * Class PeriodoRepository
 * @package Modules\Cadastro\Repositories
 */
class AppUsuarioRepository extends AbstractRepository implements RepositoryInterface
{

  protected $table = "app_usuario";
  /**
   * @var array
   */
  protected $fillable = ['nome', 'email', 'password',  'created_at', 'updated_at', 'ativo',  'remember_token', 'users_id'];
  /**
   * @var array
   */
  //    protected $hidden = ['ativo'];
  /**
   * @var array'
   */
  // protected $guarded = ['id'];
  /**
   * @var bool
   */
  public $timestamps = true;


  /**
   * @param array $query_params
   * @return array
   */
  public function findAll(array $query_params): array
  {
    $params = [];

    // Carrega os registro conforme filtros aplicados.
    $select = \DB::table('app_usuario AS U')
      ->select('U.*');

    if (user()->role_id > 2) {
      $select->where(['U.users_id' => user()->role_id]);
    }

    if ($query_params['search']['id'] > 0) {
      $select->where(['U.id' => (int)$query_params['search']['id']]);
    }

    if (!empty($query_params['search']['nome'])) {
      $select->where('U.nome', 'LIKE', "%{$query_params['search']['nome']}%");
    }

    if (is_numeric($query_params['search']['status'])) {
      $select->where(['U.ativo' => $query_params['search']['status']]);
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
      $data[] = ['DT_RowId' => $row->id, $row->id, $row->nome, $row->email, $row->ativo];
    }

    // Set total amount of table
    if (count($params)) {
      $recordsTotal = $this->count();
    } else {
      $recordsTotal = $recordsFiltered;
    }

    //var_dump($data);

    return [
      'recordsFiltered' => $recordsFiltered,
      'recordsTotal' => $recordsTotal,
      'data' => $data
    ];
  }
}
