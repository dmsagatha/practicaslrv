<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  use HasFactory;

  protected $fillable = [
    'name', 'acronym', 'description'
  ];

  public function getRouteKeyName()
  {
    return 'acronym';
  }

  public function users()
  {
    return $this->hasMany(User::class)->orderBy('names');
  }
}