<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  use HasFactory;
  protected $table = 'attendances';
  protected $fillable = [
    'id_student',
    'id_class',
    'id_parent',
    'date',
    'status'
  ];
  public $timestamps = false;

  public function student()
  {
    return $this->belongsTo(Student::class, 'id_student');
  }

  public function parent()
  {
    return $this->belongsTo(User::class, 'id_parent');
  }

  public function classes()
  {
    return $this->belongsTo(Classes::class, 'id_class');
  }
}
