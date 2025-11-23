<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = ['role_name'];

  public function users()
  {
    return $this->hasMany(User::class, 'role_id');
  }

  public function teachers()
  {
    return $this->hasMany(Teacher::class, 'role_id');
  }

  public function keamanan()
  {
    return $this->hasMany(Permission::class, 'role_id');
  }
}
