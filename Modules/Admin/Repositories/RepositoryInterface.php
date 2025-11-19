<?php

namespace Modules\Admin\Repositories;

/**
 * Interface RepositoryInterface
 * @package Modules\Core\Repositories
 */
interface RepositoryInterface
{
  /**
   * @param array $query_params
   * @return mixed
   */
  public function findAll(array $query_params);

  /**
   * @param array $query_params
   * @param array $columns
   * @return object
   */
  public function findOne(array $query_params, $columns = array('*'));

  /**
   * @param $field
   * @param $value
   * @param array $columns
   * @return mixed
   */
  public function findBy($field, $value, $columns = array('*'));
}
