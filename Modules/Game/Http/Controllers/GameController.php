<?php

namespace Modules\Game\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Game\Services\GameService;
use Illuminate\Contracts\Support\Renderable;

class GameController extends Controller
{

   /**
    * @var GameService
    */
   private $service;

   /**
    * PeriodoController constructor.
    * @param GameService $service
    */
   public function __construct(GameService $service)
   {
      $this->service = $service;
   }

   /**
    * Display a listing of the resource.
    * @return Response
    */
   public function index()
   {
      return view('game::index');
   }

   /**
    * Update resource in storage.
    * @param GameRequest $request
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
    * @param GameRequest $request
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
      return view('game::show');
   }

   /**
    * Show the form for editing the specified resource.
    * @return Response
    */
   public function edit($id)
   {
      return $this->service->edit($id);
   }

   public function finalizaPartida($id)
   {
      return $this->service->finalizaPartida($id);
   }

   public function gm($chave)
   {
      return $this->service->gm($chave);
   }

   /**
    * Update the specified resource in storage.
    * @param  Request $request
    * @return Response
    */
   public function update(GameRequest $request, $id)
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
}
