<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurahJuzSeeder extends Seeder
{
  public function run(): void
  {
    // Pembagian Juz Standar Mushaf Madinah (dominant surah)
    $data = [
      // JUZ 1
      ['id' => 1, 'juz' => 1],  // Al-Fatihah
      ['id' => 2, 'juz' => 1],  // Al-Baqarah

      // JUZ 2
      ['id' => 3, 'juz' => 2],  // Ali 'Imran

      // JUZ 3
      ['id' => 4, 'juz' => 3],  // An-Nisa'

      // JUZ 4
      ['id' => 5, 'juz' => 4],  // Al-Ma'idah

      // JUZ 5
      ['id' => 6, 'juz' => 5],  // Al-An'am

      // JUZ 6
      ['id' => 7, 'juz' => 6],  // Al-A'raf

      // JUZ 7
      ['id' => 8, 'juz' => 7],  // Al-Anfal
      ['id' => 9, 'juz' => 7],  // At-Taubah

      // JUZ 8
      ['id' => 10, 'juz' => 8], // Yunus
      ['id' => 11, 'juz' => 8], // Hud

      // JUZ 9
      ['id' => 12, 'juz' => 9], // Yusuf

      // JUZ 10
      ['id' => 13, 'juz' => 10], // Ar-Ra'd
      ['id' => 14, 'juz' => 10], // Ibrahim
      ['id' => 15, 'juz' => 10], // Al-Hijr

      // JUZ 11
      ['id' => 16, 'juz' => 11], // An-Nahl

      // JUZ 12
      ['id' => 17, 'juz' => 12], // Al-Isra'
      ['id' => 18, 'juz' => 12], // Al-Kahfi

      // JUZ 13
      ['id' => 19, 'juz' => 13], // Maryam
      ['id' => 20, 'juz' => 13], // Ta-Ha

      // JUZ 14
      ['id' => 21, 'juz' => 14], // Al-Anbiya'
      ['id' => 22, 'juz' => 14], // Al-Hajj

      // JUZ 15
      ['id' => 23, 'juz' => 15], // Al-Mu’minun
      ['id' => 24, 'juz' => 15], // An-Nur
      ['id' => 25, 'juz' => 15], // Al-Furqan

      // JUZ 16
      ['id' => 26, 'juz' => 16], // Asy-Syu'ara
      ['id' => 27, 'juz' => 16], // An-Naml

      // JUZ 17
      ['id' => 28, 'juz' => 17], // Al-Qasas
      ['id' => 29, 'juz' => 17], // Al-Ankabut

      // JUZ 18
      ['id' => 30, 'juz' => 18], // Ar-Rum
      ['id' => 31, 'juz' => 18], // Luqman
      ['id' => 32, 'juz' => 18], // As-Sajdah

      // JUZ 19
      ['id' => 33, 'juz' => 19], // Al-Ahzab
      ['id' => 34, 'juz' => 19], // Saba'
      ['id' => 35, 'juz' => 19], // Fatir

      // JUZ 20
      ['id' => 36, 'juz' => 20], // Yasin
      ['id' => 37, 'juz' => 20], // As-Saffat
      ['id' => 38, 'juz' => 20], // Sad

      // JUZ 21
      ['id' => 39, 'juz' => 21], // Az-Zumar
      ['id' => 40, 'juz' => 21], // Ghafir
      ['id' => 41, 'juz' => 21], // Fussilat

      // JUZ 22
      ['id' => 42, 'juz' => 22], // Asy-Syura
      ['id' => 43, 'juz' => 22], // Az-Zukhruf
      ['id' => 44, 'juz' => 22], // Ad-Dukhan
      ['id' => 45, 'juz' => 22], // Al-Jasiyah

      // JUZ 23
      ['id' => 46, 'juz' => 23], // Al-Ahqaf
      ['id' => 47, 'juz' => 23], // Muhammad
      ['id' => 48, 'juz' => 23], // Al-Fath
      ['id' => 49, 'juz' => 23], // Al-Hujurat

      // JUZ 24
      ['id' => 50, 'juz' => 24], // Qaf
      ['id' => 51, 'juz' => 24], // Az-Zariyat
      ['id' => 52, 'juz' => 24], // At-Tur
      ['id' => 53, 'juz' => 24], // An-Najm
      ['id' => 54, 'juz' => 24], // Al-Qamar
      ['id' => 55, 'juz' => 24], // Ar-Rahman

      // JUZ 25
      ['id' => 56, 'juz' => 25], // Al-Waqi'ah
      ['id' => 57, 'juz' => 25], // Al-Hadid
      ['id' => 58, 'juz' => 25], // Al-Mujadilah

      // JUZ 26
      ['id' => 59, 'juz' => 26], // Al-Hashr
      ['id' => 60, 'juz' => 26], // Al-Mumtahanah
      ['id' => 61, 'juz' => 26], // As-Saff
      ['id' => 62, 'juz' => 26], // Al-Jumu'ah
      ['id' => 63, 'juz' => 26], // Al-Munafiqun

      // JUZ 27
      ['id' => 64, 'juz' => 27], // At-Taghabun
      ['id' => 65, 'juz' => 27], // At-Talaq
      ['id' => 66, 'juz' => 27], // At-Tahrim
      ['id' => 67, 'juz' => 27], // Al-Mulk
      ['id' => 68, 'juz' => 27], // Al-Qalam
      ['id' => 69, 'juz' => 27], // Al-Haqqah

      // JUZ 28
      ['id' => 70, 'juz' => 28], // Al-Ma'arij
      ['id' => 71, 'juz' => 28], // Nuh
      ['id' => 72, 'juz' => 28], // Al-Jinn
      ['id' => 73, 'juz' => 28], // Al-Muzzammil
      ['id' => 74, 'juz' => 28], // Al-Muddathir
      ['id' => 75, 'juz' => 28], // Al-Qiyamah
      ['id' => 76, 'juz' => 28], // Al-Insan
      ['id' => 77, 'juz' => 28], // Al-Mursalat

      // JUZ 29
      ['id' => 78, 'juz' => 29], // An-Naba'
      ['id' => 79, 'juz' => 29], // An-Nazi’at
      ['id' => 80, 'juz' => 29], // Abasa
      ['id' => 81, 'juz' => 29], // At-Takwir
      ['id' => 82, 'juz' => 29], // Al-Infitar
      ['id' => 83, 'juz' => 29], // Al-Mutaffifin
      ['id' => 84, 'juz' => 29], // Al-Inshiqaq
      ['id' => 85, 'juz' => 29], // Al-Buruj
      ['id' => 86, 'juz' => 29], // At-Tariq
      ['id' => 87, 'juz' => 29], // Al-A'la
      ['id' => 88, 'juz' => 29], // Al-Ghashiyah

      // JUZ 30
      ['id' => 89, 'juz' => 30], // Al-Fajr
      ['id' => 90, 'juz' => 30], // Al-Balad
      ['id' => 91, 'juz' => 30], // Ash-Shams
      ['id' => 92, 'juz' => 30], // Al-Lail
      ['id' => 93, 'juz' => 30], // Ad-Dhuha
      ['id' => 94, 'juz' => 30], // Ash-Sharh
      ['id' => 95, 'juz' => 30], // At-Tin
      ['id' => 96, 'juz' => 30], // Al-Alaq
      ['id' => 97, 'juz' => 30], // Al-Qadr
      ['id' => 98, 'juz' => 30], // Al-Bayyinah
      ['id' => 99, 'juz' => 30], // Az-Zalzalah
      ['id' => 100, 'juz' => 30], // Al-Adiyat
      ['id' => 101, 'juz' => 30], // Al-Qari'ah
      ['id' => 102, 'juz' => 30], // At-Takasur
      ['id' => 103, 'juz' => 30], // Al-Asr
      ['id' => 104, 'juz' => 30], // Al-Humazah
      ['id' => 105, 'juz' => 30], // Al-Fil
      ['id' => 106, 'juz' => 30], // Quraisy
      ['id' => 107, 'juz' => 30], // Al-Ma'un
      ['id' => 108, 'juz' => 30], // Al-Kausar
      ['id' => 109, 'juz' => 30], // Al-Kafirun
      ['id' => 110, 'juz' => 30], // An-Nasr
      ['id' => 111, 'juz' => 30], // Al-Lahab
      ['id' => 112, 'juz' => 30], // Al-Ikhlas
      ['id' => 113, 'juz' => 30], // Al-Falaq
      ['id' => 114, 'juz' => 30], // An-Nas
    ];

    foreach ($data as $row) {
      DB::table('surah')
        ->where('id', $row['id'])
        ->update(['juz' => $row['juz']]);
    }
  }
}
