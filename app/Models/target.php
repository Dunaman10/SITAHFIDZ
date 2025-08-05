<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class target extends Model
{
  use HasFactory;

  protected $table = 'target';

  protected $fillable = [
    'count_target',
    'id_class',
    'date_target'
  ];

  public function class()
  {
    return $this->belongsTo(Classes::class, 'id_class');
  }

  public function students()
  {
    return $this->hasManyThrough(
      Student::class,
      Classes::class,
      'id',
      'class_id',
      'id_class',
      'id'
    );
  }
}
