<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surah extends Model
{
  use HasFactory;
  protected $table = 'surah';
  protected $fillable = ['surah_name', 'ayat'];
  public $timestamps = false;

  public function memorizes()
  {
    return $this->hasMany(Memorize::class, 'id_surah');
  }
}
