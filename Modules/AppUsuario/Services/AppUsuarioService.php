<?php

namespace Modules\AppUsuario\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\AppUsuario\Repositories\AppUsuarioRepository;

class AppUsuarioService
{

  /**
   * @var AppUsuarioRepository
   */
  private $repository;

  /**
   * AppUsuarioService constructor.
   * @param AppUsuarioRepository $repository
   */
  public function __construct(AppUsuarioRepository $repository)
  {
    $this->repository = $repository;
  }

  public function index()
  {
    return view('appusuario::index', []);
  }
  public function isValidate($arr, $id = 0)
  {
    return $v = Validator::make($arr, [
      'nome' => 'required|min:3|max:70',
      'email' => "required|unique:users,email,{$id},id",
    ]);
  }

  public function save($id = 0, $data, $profile = 0)
  {
    try {
      $data['nome'] = mb_strtoupper($data['nome']);
      $data['email'] = mb_strtolower($data['email']);


      $v = $this->isValidate($data, $id);


      if ($v->fails()) {
        return __format_error_html($v);
      }

      if ($id) {
        $user = $this->repository->find($id);
        // $senhaAtual = $user->password;
      } else {
        $user = $this->repository;
      }

      // if ($data['password'] && $data['password'] == $data['confirm_password']) {
      //   $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
      // }

      // $data['password'] = $data['password'] ?: $senhaAtual;

      $user->fill($data);
      $user->save();

      return response()->json(['error' => 0, 'message' => 'O registro foi salvo com sucesso.', 'data' => []], 200);
    } catch (Exception $e) {
      return response()->json(['error' => 1, 'message' => $e->getMessage(), 'data' => []], 400);
    }
  }

  public function create()
  {
    return view('appusuario::create', []);
  }

  public function edit($id)
  {
    $appUsuario = $this->repository->find($id);

    return view('appusuario::edit', ['appUsuario' => $appUsuario]);
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
          $sort = 'nome';
          break;
        case 2:
          $sort = 'email';
          break;
        case 3:
          $sort = 'ativo';
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
