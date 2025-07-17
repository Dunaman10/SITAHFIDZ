<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memorize extends Model
{
  use HasFactory;

  protected $table = 'memorizes';
  public $incrementing = true;

  protected $fillable = [
    'id_surah',
    'id_student',
    'id_teacher',
    'from',
    'to',
    'audio',
    'complete',
    'created_at',
    'updated_at',
  ];

  public function surah()
  {
    return $this->belongsTo(Surah::class, 'id_surah');
  }

  public function student()
  {
    return $this->belongsTo(Student::class, 'id_student');
  }

  public function teacher()
  {
    return $this->belongsTo(Teacher::class, 'id_teacher');
  }
}
