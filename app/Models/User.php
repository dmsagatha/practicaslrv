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
  
  public function scopeFilter(Builder $query, Request $request): Builder
  {
    return $query->when($request->has('last_name'), function ($query) use ($request) {
        return $query->where('last_name', $request->last_name);
    })->when($request->has('area_id'), function ($query) use ($request) {
        return $query->where('area_id', $request->area_id);
    });
  }
}