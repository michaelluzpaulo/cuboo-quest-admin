<?php

namespace Modules\Option\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Option\Services\OptionService;

class OptionController extends Controller
{
   public function __construct(
      private OptionService $service
   ) {}


   /**
    * Update resource in storage.
    * @param OptionRequest $request
    * @return \Illuminate\Http\JsonResponse
    */
   // public function data($scenario_id)
   // {
   //    ["scenario_id" => $scenario_id]
   //    return $this->service->findAll($scenario_id);
   // }
   public function data(Request $request, $scenario_id)
   {
      $data = $request->all();
      $data["search"]["scenario_id"] = $scenario_id;
      return $this->service->findAll($data);
   }

   /**
    * Show the form for creating a new resource.
    * @return Response
    */
   public function create($scenario_id)
   {
      return $this->service->create($scenario_id);
   }

   /**
    * Store a newly created resource in storage.
    * @param OptionRequest $request
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
      return view('option::show');
   }

   /**
    * Show the form for editing the specified resource.
    * @return Response
    */
   public function edit($scenario_id, $id)
   {
      return $this->service->edit($scenario_id, $id);
   }

   /**
    * Update the specified resource in storage.
    * @param  Request $request
    * @return Response
    */
   public function update(Request $request, $scenario_id, $id)
   {
      $data = json_decode($request->all()['data'], true);
      return $this->service->save($id, $data);
   }

   /**
    * Remove the specified resource from storage.
    * @return Response
    */
   public function destroy($scenario_id, $id)
   {
      return $this->service->destroy($id);
   }
}
