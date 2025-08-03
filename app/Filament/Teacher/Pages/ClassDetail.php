<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Surah; // Pastikan ini diimport untuk loadSurahs()
use Illuminate\Support\Facades\DB;

class ClassDetail extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-users'; // Atau heroicon-o-document-text jika lebih cocok untuk surah
  protected static ?string $title = 'Daftar Siswa Per Kelas'; // Akan diubah oleh getTitle()
  protected static ?string $slug = 'class-detail/{classId}';
  protected static bool $shouldRegisterNavigation = false;

  public $classId;
  public $currentClass;
  public $students; // Masih ada jika nanti ada bagian untuk siswa
  public $surahs; // Ini untuk menampilkan daftar surah
  public $search = ''; // Untuk pencarian surah

  public $accordionData = []; // Data untuk accordion
  public $openSection = 1;
  public $columns = [];
  public $onEdit = true;
  public $onDelete = true;

  protected static string $view = 'filament.teacher.pages.class-detail';

  // --- PERBAIKAN DI SINI: mount() menerima ?int $classId = null ---
  public function mount(?int $classId = null): void
  {
    $this->classId = $classId;

    if ($this->classId) {
      // Jika ada classId, coba muat classId. Jika tidak ditemukan, akan otomatis 404
      $this->currentClass = Classes::find($this->classId); // Find, bukan findOrFail, agar bisa null
      if (!$this->currentClass) {
        // Handle jika classId ada tapi classIdnya tidak ditemukan di DB
        redirect()->route('filament.teacher.pages.dashboard');
        return;
      }
      $this->loadSurahs(); // Panggil metode untuk memuat surah
      $this->accordionData = $this->getAccordionData(); // Ambil data untuk accordion
      $this->columns = $this->getColumns(); // Ambil kolom untuk tabel
    } else {
      // Jika tidak ada classId di URL, arahkan ke dashboard
      redirect()->route('filament.teacher.pages.dashboard');
      return; // Penting untuk menghentikan eksekusi
    }
  }

  public function loadSurahs(): void
  {
    // Pastikan currentClass sudah dimuat sebelum mengakses relasi
    // Jika Anda ingin surah terfilter per classId, pastikan ada relasi di model Surah ke Class
    // Atau filter berdasarkan logika lain jika semua surah muncul di semua classId
    $query = Surah::orderBy('id');

    if (!empty($this->search)) {
      $query->where('surah_name', 'like', '%' . $this->search . '%');
      // Tambahkan filter lain jika diperlukan, misal by ayat
    }

    $this->surahs = $query->get();
  }

  public function updatedSearch(): void
  {
    $this->loadSurahs();
  }

  protected function getAccordionData(): array
  {
    $rawData = DB::table('memorizes')
      ->select(
        'memorizes.id_surah',
        'surah.surah_name as surah_name',
        'memorizes.id',
        'students.student_name as student_name',
        'memorizes.from',
        'users.name',
        'memorizes.to',
        'memorizes.audio',
        'memorizes.complete'
      )
      ->join('surah', 'memorizes.id_surah', '=', 'surah.id')
      ->join('students', 'memorizes.id_student', '=', 'students.id')
      ->join('teachers', 'memorizes.id_teacher', '=', 'teachers.id')
      ->join('class_teacher', 'teachers.id', '=', 'class_teacher.id_teacher')
      ->join('classes', 'class_teacher.id_class', '=', 'classes.id')
      ->join('users', 'teachers.id_users', '=', 'users.id')
      ->where('classes.id', $this->classId)
      ->orderBy('memorizes.id_surah')
      ->get();

    // Group by surah
    $grouped = $rawData->groupBy('id_surah');

    return $grouped->map(function ($items, $idSurah) {
      return [
        'id' => $idSurah,
        'surah' => $items[0]->surah_name,
        'data' => $items->map(function ($item) {
          return [
            'id' => $item->id,
            'student_name' => $item->student_name,
            "teacher_name" => $item->name,
            'from' => $item->from,
            'to' => $item->to,
            'audio' => $item->audio,
            'complete' => $item->complete,
          ];
        })->toArray()
      ];
    })->values()->toArray();
  }

  protected function getColumns(): array
  {
    return [
      ['header' => 'Siswa', 'key' => 'student_name'],
      ['header' => 'Guru', 'key' => 'teacher_name'],
      ['header' => 'Mulai', 'key' => 'from'],
      ['header' => 'Selesai', 'key' => 'to'],
      ['header' => 'Audio', 'key' => 'audio'],
      ['header' => 'Status', 'key' => 'complete'],
    ];
  }

  public function getTitle(): string
  {
    // Gunakan $this->currentClass yang sudah dimuat di mount()
    return $this->currentClass ? 'Daftar Surah Kelas ' . $this->currentClass->class_name : 'Pilih classId';
  }

  public static function getRoute(string $page): string
  {
    return static::getUrl(['classId' => $page], panel: 'teacher');
  }
}
