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
    'date',
    'status'
  ];
  // public $timestamps = false;

  public function student()
  {
    return $this->belongsTo(Student::class, 'id_student');
  }

  public function classes()
  {
    return $this->belongsTo(Classes::class, 'id_class');
  }

  public function scopeBetweenDates($query, $from, $to)
  {
    return $query->whereBetween('date', [$from, $to]);
  }
}
