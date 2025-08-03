<?php

namespace App\Filament\Teacher\Pages;

use Filament\Pages\Page;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Surah; // Pastikan ini diimport untuk loadSurahs()

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

    protected static string $view = 'filament.teacher.pages.class-detail';

    // --- PERBAIKAN DI SINI: mount() menerima ?int $classId = null ---
    public function mount(?int $classId = null): void
    {
        $this->classId = $classId;

        if ($this->classId) {
            // Jika ada classId, coba muat kelas. Jika tidak ditemukan, akan otomatis 404
            $this->currentClass = Classes::find($this->classId); // Find, bukan findOrFail, agar bisa null
            if (!$this->currentClass) {
                // Handle jika classId ada tapi kelasnya tidak ditemukan di DB
                redirect()->route('filament.teacher.pages.dashboard');
                return;
            }
            $this->loadSurahs(); // Panggil metode untuk memuat surah
        } else {
            // Jika tidak ada classId di URL, arahkan ke dashboard
            redirect()->route('filament.teacher.pages.dashboard');
            return; // Penting untuk menghentikan eksekusi
        }
    }

    public function loadSurahs(): void
    {
        // Pastikan currentClass sudah dimuat sebelum mengakses relasi
        // Jika Anda ingin surah terfilter per kelas, pastikan ada relasi di model Surah ke Class
        // Atau filter berdasarkan logika lain jika semua surah muncul di semua kelas
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

    public function getTitle(): string
    {
        // Gunakan $this->currentClass yang sudah dimuat di mount()
        return $this->currentClass ? 'Daftar Surah Kelas ' . $this->currentClass->class_name : 'Pilih Kelas';
    }

    public static function getRoute(string $page): string
    {
        return static::getUrl(['classId' => $page], panel: 'teacher');
    }
}