<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = ['id_users'];

  public function user()
  {
    return $this->belongsTo(User::class, 'id_users');
  }

  public function classes()
  {
    return $this->hasMany(ClassTeacher::class, 'id_teacher');
  }

  public function memorizes()
  {
    return $this->hasMany(Memorize::class, 'id_teacher');
  }

  protected static function booted()
  {
    static::deleted(function ($teacher) {
      $teacher->user()->delete();
    });
  }
}
