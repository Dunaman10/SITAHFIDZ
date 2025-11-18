<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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
    'nilai',
    'approved_by',
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

  public static function boot()
  {
    parent::boot();

    // Hapus audio saat record dihapus
    static::deleting(function ($memorize) {
      if ($memorize->audio && Storage::disk('public')->exists($memorize->audio)) {
        Storage::disk('public')->delete($memorize->audio);
      }
    });

    // Hapus audio lama saat diganti
    static::updating(function ($memorize) {
      if ($memorize->isDirty('audio')) {
        $old = $memorize->getOriginal('audio');
        if ($old && Storage::disk('public')->exists($old)) {
          Storage::disk('public')->delete($old);
        }
      }
    });
  }
}
