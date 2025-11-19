<?php

namespace Modules\Site\Http\Controllers;

use App\Mail\AssociadoEmail;
use App\Mail\ContatoEmail;
use DeepCopy\Filter\Filter;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Institucional\Repositories\InstitucionalRepository;

class SiteController extends Controller
{
  public $dominio_id;

  public function __construct()
  {
    $this->dominio_id = env('APP_DOMINIO_ID');
  }
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {
    return redirect('/login');
    // return view('site::index', []);
  }

  public function interacoes($codigo)
  {
    $comunicacao = DB::table("comunicacao")->whereRaw("codigo = '{$codigo}'")->first();

    $interacoes = DB::table("interacao")
      ->whereRaw("comunicacao_id={$comunicacao->id}")
      ->get();

    $empresa = DB::table('empresa')->where('id', $comunicacao->empresa_id)->first();

    return view('site::interacoes', ['comunicacao' => $comunicacao, 'empresa' => $empresa, 'interacoes' => $interacoes, 'codigo' => $codigo]);
  }
}
