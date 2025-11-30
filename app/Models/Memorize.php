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
    'foto',
    'from',
    'to',
    'audio',
    'nilai_avg',
    'makharijul_huruf',
    'shifatul_huruf',
    'ahkamul_qiroat',
    'ahkamul_waqfi',
    'qowaid_tafsir',
    'tarjamatul_ayat',
    'juz',
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

  public static function booted()
  {
    static::saving(function ($model) {

      // Konversi huruf ke angka (nilai tengah)
      $map = [
        'A' => 90,
        'B' => 65,
        'C' => 40,
        'D' => 15,
      ];

      $fields = [
        $model->makharijul_huruf,
        $model->shifatul_huruf,
        $model->ahkamul_qiroat,
        $model->ahkamul_waqfi,
        $model->qowaid_tafsir,
        $model->tarjamatul_ayat,
      ];

      // Ambil nilai angka
      $numericValues = array_map(fn($x) => $map[$x] ?? null, $fields);
      $numericValues = array_filter($numericValues);

      if (!empty($numericValues)) {
        $avg = array_sum($numericValues) / count($numericValues);

        // Tentukan huruf berdasarkan range
        if ($avg >= 75) {
          $model->nilai_avg = 'A';
        } elseif ($avg >= 50) {
          $model->nilai_avg = 'B';
        } elseif ($avg >= 25) {
          $model->nilai_avg = 'C';
        } else {
          $model->nilai_avg = 'D';
        }
      }
    });
  }
}
