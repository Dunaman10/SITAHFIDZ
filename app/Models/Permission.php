<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  use HasFactory;
  protected $table = 'permissions';
  protected $fillable = [
    'id_student',
    'id_parent',
    'reason',
    'date_out',
    'date_in',
    'status',
    'approved_by'
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
}
