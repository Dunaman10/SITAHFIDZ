<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorStudent extends Model
{
  protected $fillable = ['id_teacher', 'id_student'];

  public function teacher()
  {
    return $this->belongsTo(Teacher::class, 'id_teacher');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'id_users');
  }

  public function student()
  {
    return $this->belongsTo(Student::class, 'id_student');
  }

  protected static function booted()
  {
    static::created(function ($pivot) {
      $pivot->student()->update([
        'id_teacher' => $pivot->id_teacher
      ]);
    });
  }
}
