<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use kcfinder\session;

class AdminController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Renderable
   */
  public function index()
  {

    // return view('admin::index');
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
    $_SESSION['ADMIN_MLP'] = date('Y-m-d H:i:s');

    if (!user()) {
      // session()->flush();
      // Auth::logout();
      // return redirect('login');
      return view('auth.login', ['error' => 'Você não tem acesso ou sua sessão expirou, faça login novamente.']);
    }

    return redirect('admin/usuarios');
  }
}
