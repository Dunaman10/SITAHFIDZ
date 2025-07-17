<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
  use HasFactory;

  protected $table = 'classes';
  protected $fillable = ['class_name'];
  public $timestamps = false;

  public function students()
  {
    return $this->hasMany(Student::class, 'class_id');
  }

  public function classTeachers()
  {
    return $this->hasMany(ClassTeacher::class, 'id_class');
  }
}
