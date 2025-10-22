<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = [
    'student_name',
    'parent',
    'class_id',
    'profile',
    'tanggal_lahir',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'parent');
  }

  public function class()
  {
    return $this->belongsTo(Classes::class, 'class_id');
  }

  public function memorizes()
  {
    return $this->hasMany(Memorize::class, 'id_student');
  }
}
