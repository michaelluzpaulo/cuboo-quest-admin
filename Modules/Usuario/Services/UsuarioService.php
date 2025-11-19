<?php

namespace Modules\Usuario\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Usuario\Repositories\UsuarioRepository;

class UsuarioService
{

  /**
   * @var UsuarioRepository
   */
  private $repository;

  /**
   * UsuarioService constructor.
   * @param UsuarioRepository $repository
   */
  public function __construct(UsuarioRepository $repository)
  {
    $this->repository = $repository;
  }

  public function index()
  {
    return view('usuario::index', []);
  }
  public function isValidate($arr, $id = 0)
  {
    return $v = Validator::make($arr, [
      'name' => 'required|min:3|max:70',
      'role_id' => 'required|numeric',
      'email' => "required|unique:users,email,{$id},id",
    ]);
  }

  public function isValidateProfile($arr)
  {
    return $v = Validator::make($arr, [
      'name' => 'required|min:3|max:70',
      'email' => 'required',
    ]);
  }

  public function save($id = 0, $data, $profile = 0)
  {
    try {
      $data['name'] = mb_strtoupper($data['name']);
      $data['email'] = mb_strtolower($data['email']);

      if ($profile == 0) {
        $v = $this->isValidate($data, $id);
      } else {
        $v = $this->isValidateProfile($data);
      }

      if ($v->fails()) {
        return __format_error_html($v);
      }

      if ($id) {
        $user = $this->repository->find($id);
        $senhaAtual = $user->password;
      } else {
        $user = $this->repository;
      }

      if ($data['password'] && $data['password'] == $data['confirm_password']) {
        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
      }

      $data['password'] = $data['password'] ?: $senhaAtual;

      $user->fill($data);
      $user->save();

      return response()->json(['error' => 0, 'message' => 'O registro foi salvo com sucesso.', 'data' => []], 200);
    } catch (Exception $e) {
      return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 400);
    }
  }

  public function create()
  {
    $roles = $this->repository->listRole();
    return view('usuario::create', ['roles' => $roles]);
  }

  public function edit($id)
  {
    $usuario = $this->repository->find($id);
    $roles = $this->repository->listRole();

    return view('usuario::edit', ['roles' => $roles, 'usuario' => $usuario]);
  }

  public function editProfile($id)
  {
    $id = user()->id;
    $usuario = $this->repository->find($id);
    return view('usuario::profile', ['usuario' => $usuario]);
  }

  public function destroy($id)
  {
    $user = $this->repository->find($id);
    $user->delete();
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
      $search['nome'] = filter_var($search['nome'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $search['status'] = $search['status'];

      switch ((int)$order[0]['column']) {
        case 0:
          $sort = 'id';
          break;
        case 1:
          $sort = 'name';
          break;
        case 2:
          $sort = 'email';
          break;
        case 3:
          $sort = 'role_name';
          break;
        case 4:
          $sort = 'person_name';
          break;
        case 5:
          $sort = 'active';
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
