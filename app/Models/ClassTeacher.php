<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassTeacher extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $table = 'class_teacher';
  protected $fillable = [
    'id_class',
    'id_teacher',
  ];

  public function class()
  {
    return $this->belongsTo(Classes::class, 'id_class');
  }

  public function teacher()
  {
    return $this->belongsTo(Teacher::class, 'id_teacher');
  }
}
