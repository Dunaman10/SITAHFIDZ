<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Surah; // Pastikan ini diimport untuk loadSurahs()
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ClassDetail extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-users'; // Atau heroicon-o-document-text jika lebih cocok untuk surah
  protected static ?string $title = 'Daftar Siswa Per Kelas'; // Akan diubah oleh getTitle()
  protected static ?string $slug = 'class-detail/{classId}';
  protected static bool $shouldRegisterNavigation = false;

  use WithPagination;

  protected $queryString = [
    'search'  => ['except' => ''],
    'page'    => ['except' => 1],
    'perPage' => ['except' => 10],
  ];

  public $classId;
  public $currentClass;
  public $students; // Masih ada jika nanti ada bagian untuk siswa
  public $surahs; // Ini untuk menampilkan daftar surah
  public $search = ''; // Untuk pencarian surah

  public $accordionData = []; // Data untuk accordion
  public $columns = [];
  public $onEdit = true;
  public $onDelete = true;

  protected static string $view = 'filament.teacher.pages.class-detail';

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
      // dd($this->accordionData[0]);
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
    $this->accordionData = $this->getAccordionData();
  }

  protected function getAccordionData(): array
  {
    $teacherId = DB::table('teachers')
      ->where('id_users', auth()->id())
      ->value('id');

    // Gunakan surahs yang udah di-filter dari loadSurahs()
    $allSurahs = $this->surahs ?? Surah::orderBy('id')->get(['id', 'surah_name']);

    $rawMem = DB::table('memorizes')
      ->select(
        'memorizes.id_surah',
        'memorizes.id',
        'students.student_name',
        'users.name as teacher_name',
        'memorizes.from',
        'memorizes.to',
        'memorizes.audio',
        'memorizes.complete'
      )
      ->join('students', 'memorizes.id_student', '=', 'students.id')
      ->join('teachers', 'memorizes.id_teacher', '=', 'teachers.id')
      ->join('users', 'teachers.id_users', '=', 'users.id')
      ->join('classes', 'students.class_id', '=', 'classes.id')
      ->where('classes.id', $this->classId)
      ->where('teachers.id', $teacherId)
      ->orderBy('memorizes.id_surah')
      ->get()
      ->groupBy('id_surah');

    // 🧩 DEBUG MODE
    // if ($rawMem->isEmpty()) {
    //   dd('❌ Tidak ada data di tabel memorizes untuk kelas ini', [
    //     'classId' => $this->classId,
    //     'teacherId' => $teacherId,
    //   ]);
    // }

    return $allSurahs->map(function ($s) use ($rawMem) {
      $items = $rawMem->get($s->id, collect());

      return [
        'id'    => $s->id,
        'surah' => $s->surah_name,
        'data'  => $items->map(function ($item) {
          return [
            'id'           => $item->id,
            'student_name' => $item->student_name,
            'teacher_name' => $item->teacher_name,
            'from'         => $item->from,
            'to'           => $item->to,
            'audio'        => $item->audio,
            'complete'     => (int) $item->complete,
          ];
        })->values()->toArray(),
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
