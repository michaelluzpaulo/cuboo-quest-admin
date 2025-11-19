<?php

namespace Modules\Tema\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Tema\Services\TemaService;
use Modules\Tema\Services\TemaFotoService;

class TemaController extends Controller
{
   /**
    * @var TemaService
    */
   private $service;
   private $temaFotoService;

   /**
    * PeriodoController constructor.
    * @param TemaService $service
    */
   public function __construct(TemaService $service, TemaFotoService $temaFotoService)
   {
      $this->service = $service;
      $this->temaFotoService = $temaFotoService;
   }
   /**
    * Display a listing of the resource.
    * @return Response
    */
   public function index()
   {
      return view('tema::index');
   }

   /**
    * Update resource in storage.
    * @param TemaRequest $request
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
    * @param TemaRequest $request
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
      return view('tema::show');
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

   /**
    * Remove the specified resource from storage.
    * @return Response
    */
   public function destroy($id)
   {
      return $this->service->destroy($id);
   }
   public function cloneTema($id)
   {
      return $this->service->cloneTema($id);
   }

   public function updateFoto(Request $request, $id)
   {
      return $this->temaFotoService->saveFoto($id, $request);
   }
   public function destroyFoto(Request $request, $id)
   {
      $campo = $request->campo;
      return $this->temaFotoService->destroyFoto($id, $campo);
   }
}
