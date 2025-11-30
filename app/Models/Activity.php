<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  use HasFactory;
  protected $table = 'activities';
  protected $fillable = ['activity_name', 'description', 'keterangan', 'activity_date'];
  public $timestamps = false;

  public function users()
  {
    return $this->belongs(User::class, 'id');
  }
}
