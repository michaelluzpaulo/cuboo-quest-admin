<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function registerUser()
{
  $user = Auth::user();

  if (!$user) {
    Auth::logout();
    session()->flush();
    return redirect('/login');
  }

  $userExtra = new stdClass();
  // attach role name to object user
  $userExtra->role_name = $user->role->name;

  // register user object in the session
  session(['user' => $user, 'userExtra' => $userExtra]);
}

function user()
{
  $userBF = session('user', null);

  if (!$userBF) {
    registerUser();
  }
  return session('user', null);
}

function userExtra()
{
  return session('userExtra', null);
}

function cliente()
{
  return session('cliente', null);
}

function __logoImg()
{
  return user()->avatar ?: base_path('public/img/logo.png');
}

function avatar()
{
  $image = user()->avatar ?: base_path('public/img/avatar.png');

  $data = base64_encode(file_get_contents($image));

  $src = "data:image/png;base64,{$data}";

  return $src;
}

function __logo()
{
  $image = __logoImg();

  $data = base64_encode(file_get_contents($image));

  $src = "data:image/png;base64,{$data}";

  return $src;
}

function __logoMini()
{
  $image = user()->avatar ?: base_path('public/img/logo_pq.png');

  $data = base64_encode(file_get_contents($image));

  $src = "data:image/png;base64,{$data}";

  return $src;
}

function customer()
{
  if (!session()->get('customer')) {
    $n = new stdClass();
    $n->nome_fantasia = env('APP_TITLE');
    session(['customer' => $n]);
  }
  return session()->get('customer');
}
