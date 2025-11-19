<?php

namespace Modules\Usuario\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\Admin\Repositories\RepositoryInterface;

/**
 * Class UsuarioRepository
 * @package Modules\Usuario\Repositories
 */
class UsuarioRepository extends AbstractRepository implements RepositoryInterface
{
  /**
   * @var string
   */
  protected $table = "users";
  /**
   * @var array
   */
  protected $fillable = ['role_id', 'name', 'email', 'password', 'avatar', 'created_at', 'updated_at', 'active', 'nivel_id'];
  /**
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];
  /**
   * @var array
   */
  // protected $guarded = ['id'];
  /**
   * @var bool
   */
  public $timestamps = true;

  /**
   * @return array
   */
  public function listRole(): array
  {
    $rows = DB::table('role');
    if (user()->role_id != 1) {
      $rows->where('role.id', '>', 1);
    }


    $data = [];

    foreach ($rows->get() as $row) {
      $data[] = ['id' => $row->id, 'name' => $row->name];
    }
    return $data;
  }

  /**
   * @param array $query_params
   * @return array
   */
  public function findAll(array $query_params): array
  {
    $params = [];

    // Carrega os registro conforme filtros aplicados.
    $select = DB::table('users AS T_USERS')
      ->select(
        'T_USERS.id',
        'T_USERS.name',
        'T_USERS.email',
        'T_USERS.role_id',
        'T_ROLE.name as role_name',
        'T_USERS.active'
      )
      ->join('role AS T_ROLE', 'T_ROLE.id', 'T_USERS.role_id');

    if (user()->role_id > 1) {
      $select->where('T_USERS.role_id', '>', 1);
    }

    if ($query_params['search']['id'] > 0) {
      $select->where(['T_USERS.id' => (int)$query_params['search']['id']]);
    }

    if (!empty($query_params['search']['nome'])) {
      $select->where('T_USERS.name', 'LIKE', "%{$query_params['search']['nome']}%");
    }

    if (is_numeric($query_params['search']['status'])) {
      $select->where(['T_USERS.active' => $query_params['search']['status']]);
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
      $data[] = ['DT_RowId' => $row->id, $row->id, $row->name, $row->email, $row->role_name,  $row->active];
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
