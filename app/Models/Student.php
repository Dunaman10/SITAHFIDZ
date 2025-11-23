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
    return $this->hasOne(Memorize::class, 'id_student')
      ->latest('created_at');
  }

  public function pembimbing()
  {
    return $this->belongsToMany(
      Teacher::class,
      'mentor_students',
      'id_student',
      'id_teacher'
    );
  }


  protected static function booted()
  {
    static::created(function ($student) {
      Attendance::firstOrCreate([
        'id_student' => $student->id,
        'date' => now()->format('Y-m-d'),
      ], [
        'id_class' => $student->class_id,
        'status' => null,
      ]);
    });
  }
}
