<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'password',
    'area_id',
  ];

  public function area()
  {
    return $this->belongsTo(Area::class);
  }

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
  
  /**
   * Filtros - https://www.laravelia.com/post/dropdown-search-filter-in-laravel-10-tutorial
   * 
   * Laravel Advance Filter | Multiple Filters | whereHas filter using Relatioship | Eloquent Query
   * https://www.youtube.com/watch?v=PBSiQLPQDmQ&ab_channel=CodeOnline
   */
  public function scopeList()
  {
    return User::query()
      ->with('area')
      ->when(request()->area, function ($query) {
          $query->where('area_id', request('area'));
        })
      ->when(request()->lastName, function ($query) {
          $query->where('last_name', request('lastName'));
        })
      ->orderBy('last_name')
      ->get();
  }
}