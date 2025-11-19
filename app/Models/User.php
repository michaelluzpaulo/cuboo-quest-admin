<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  const ROLE_ROOT = 1;
  const ROLE_ADMINISTRADOR = 2;
  const ROLE_PADRAO = 3;
  const ROLE_ASSOCIADO = 4;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'active',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function role()
  {
    return $this->hasOne('\Modules\Usuario\Repositories\RoleRepository', 'id', 'role_id');
  }

  public function isAdministrador()
  {
    return $this->role_id === self::ROLE_ADMINISTRADOR;
  }

  public function isPadrao()
  {
    return $this->role_id === self::ROLE_PADRAO;
  }

  public function isAssociado()
  {
    return $this->role_id === self::ROLE_ASSOCIADO;
  }
}
