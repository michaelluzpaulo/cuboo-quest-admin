<?php

namespace Modules\Admin\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractRepository
 * @package Modules\Core\Repositories
 */
abstract class AbstractRepository extends Model
{
  /**
   * @var array
   */
  protected $fillable = ['*'];

  /**
   * @var bool
   */
  public $timestamps = false;


  /**
   * @param array $query_array_params ['campo' => valor] || ['campo' => valor,'campo' => valor]
   * @param array $columns
   * @return null|object
   */
  public function findOne(array $query_array_params, $columns = ['*'])
  {
    return $this->select($columns)->where($query_array_params)->orderBy('id', 'desc')->first();
  }

  /**
   * @param $field
   * @param $value
   * @param array $columns
   * @return mixed
   */
  public function findBy($field, $value, $columns = ['*'], $order = '')
  {
    $query = $this->select($columns)->where([$field => $value]);

    if ($order) {
      $query->orderByRaw($order);
    }
    return $query->get();
  }


  /**
   * @param array $query_array_params ['campo' => valor] || ['campo' => valor,'campo' => valor]
   * @param array $columns
   * @param string $order
   * @return mixed
   */
  public function findByArray(array $query_array_params = [], $columns = ['*'], $order = '', $whereRaw = '')
  {
    $query = $this->select($columns);
    if (count($query_array_params) > 0) {
      $query->where($query_array_params);
    }

    if ($whereRaw) {
      $query->whereRaw($whereRaw);
    }

    if ($order) {
      $query->orderByRaw($order);
    }

    return $query->get();
  }

  /**
   * @param string $param (titulo ou nome)
   * @param $id (id atual do registro)
   * @return null|string|string[]
   */
  public function autoSaveRefAmigavel($param = '')
  {
    $this->ref_amigavel = __urlAmigavel($param);
    if ($this->isDuplicityRefAmigavel($this->ref_amigavel, $this->id)) {
      $this->ref_amigavel .= '__' . $this->id;
    }
    $this->save();
  }

  public function isDuplicityRefAmigavel($ref_amigavel, $id = 0)
  {
    $id = (int) $id;
    $query = $this->selectRaw('COUNT(*) AS CONT');
    $query->whereRaw("ref_amigavel = '{$ref_amigavel}' && id != $id");
    $dado =  $query->first();
    return $dado->CONT > 0 ? true : false;
  }

  /**
   * @param string $param (titulo ou nome)
   * @param $id (id atual do registro)
   * @return null|string|string[]
   */
  public function autoSaveRefAmigavel2($campo, $param)
  {
    $this->{$campo} = __urlAmigavel($param);
    if ($this->isDuplicityRefAmigavel2($campo, $this->{$campo}, $this->id)) {
      $this->{$campo} .= '__' . $this->id;
    }
    $this->save();
  }

  public function isDuplicityRefAmigavel2($campo, $ref_amigavel, $id = 0)
  {
    $id = (int) $id;
    $query = $this->selectRaw('COUNT(*) AS CONT');
    $query->whereRaw("{$campo} = '{$ref_amigavel}' && id != $id");
    $dado =  $query->first();
    return $dado->CONT > 0 ? true : false;
  }
}
