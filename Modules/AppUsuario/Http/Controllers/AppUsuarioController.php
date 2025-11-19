<?php

namespace Modules\AppUsuario\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\AppUsuario\Services\AppUsuarioService;



class AppUsuarioController extends Controller
{
  /**
   * @var AppUsuarioService
   */
  private $service;

  /**
   * AppUsuarioController constructor.
   * @param AppUsuarioService $service
   */
  public function __construct(AppUsuarioService $service)
  {
    $this->service = $service;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
    return $this->service->index();
  }

  /**
   * Update resource in storage.
   * @param AppUsuarioRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function data(Request $request)
  {
    return $this->service->findAll($request);
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return $this->service->create();
  }

  /**
   * Store a newly created resource in storage.
   * @param AppUsuarioRequest $request
   */
  public function store(Request $request)
  {
    $data = json_decode($request->all()['data'], true);
    return $this->service->save(0, $data);
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show()
  {
    return view('appusuario::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit($id)
  {
    return $this->service->edit($id);
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request, $id)
  {
    $data = json_decode($request->all()['data'], true);
    return $this->service->save($id, $data);
  }

  public function updateProfile(Request $request, $id)
  {
    $data = json_decode($request->all()['data'], true);
    return $this->service->save($id, $data, 1);
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function destroy($id)
  {
    return $this->service->destroy($id);
  }
}
