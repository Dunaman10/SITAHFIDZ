<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Pondok Pesantren Modern dan Tahfidz Al-Qur'an Darut Tafsir Darut Tafsir</title>

  {{-- Tailwind CSS --}}
  @vite('resources/css/app.css')

  {{-- FontAwesome --}}
  <script src="https://kit.fontawesome.com/b9470f7400.js" crossorigin="anonymous"></script>

  <link rel="icon" href="/assets/logo-darutafsir.png">
</head>
<body class="bg-slate-100">

  {{-- Navbar --}}
  <nav id="navbar" class="text-white fixed w-full z-10 top-0 left-0 flex justify-between items-center px-6 md:px-16 py-4 transition-all duration-300">

      {{-- Logo --}}
      <div class="flex items-center gap-2">
          <a href="{{ route('index') }}">
              <img src="/assets/logo-darutafsir.png" alt="Darut Tafsir Logo" class="h-12">
          </a>
          <h1 class="text-2xl font-bold">Darut Tafsir</h1>
      </div>

      <div class="flex items-center gap-24">
          <div class="hidden md:flex gap-6 font-semibold text-lg">
              <a href="#" class="home text-pink-600 font-bold">Home</a>
              <a href="#about" class="about">Tentang Pondok</a>
              <a href="#contact" class="contact">Kontak</a>
          </div>
          <div>
              <a href="/auth/login" class="bg-pink-600 px-4 py-2 rounded-lg text-lg font-semibold hover:bg-pink-500">Login</a>
          </div>
      </div>

  </nav>
  {{-- ./Navbar --}}

  {{-- Main Content --}}
  <div>
    {{-- Hero Section --}}
    <section class="relative h-screen bg-cover bg-center" style="background-image: url('/assets/masjid.jpg');">
       <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/30"></div>
      <div class="relative text-white w-full h-full flex justify-content-between items-center">
        <div class="mb-32 mx-6 md:mx-16 max-w-4xl mt-24">
          <h2 class="font-bold text-3xl sm:text-6xl mb-2">Masuk ke Lingkungan Belajar yang Lebih Bermakna</h2>
          <p class="text-sm sm:text-lg mb-5 text-justify">Kami percaya setiap santri berhak mendapatkan pendidikan yang terarah, penuh nilai, dan dibimbing oleh para pengajar yang berdedikasi. Bergabunglah bersama kami untuk merasakan proses belajar yang bukan hanya menambah ilmu, tapi juga membentuk karakter dan akhlak.</p>
          <a href="https://docs.google.com/forms/d/e/1FAIpQLSdWsuLWlCtjpn0UfI1gCFHQsllw0NqIxxpFWgsPJ24gAQMkJw/viewform" class="bg-pink-600  px-4 py-2 rounded-lg text-sm sm:text-lg font-semibold hover:bg-pink-400" target="blank">Daftar Sekarang</a>
        </div>
      </div>
    </section>
    {{-- ./Hero Section --}}

    {{-- Tentang Pondok Section --}}
    <section id="about" class="py-16 px-8 sm:text-center">
      <h3 class="text-3xl font-bold mb-6">Tentang Pondok Pesantren Darut Tafsir</h3>
      <p class="text-lg max-w-3xl text-justify sm:text-center sm:mx-auto">Pondok Pesantren Modern dan Tahfidz Al-Qur'an Darut Tafsir didirikan dengan tujuan mencetak generasi muda yang tidak hanya menguasai ilmu agama, tetapi juga memiliki karakter yang kuat dan akhlak yang mulia. Kami menyediakan lingkungan belajar yang kondusif dengan fasilitas lengkap untuk mendukung proses pembelajaran santri.</p>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mx-auto mt-5 sm:w-[70%]">

        <div class="bg-white shadow w-full rounded-lg p-12 text-slate-800">
          <div class="flex items-center gap-3 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
            </svg>
            <h2 class="text-3xl font-bold">Visi</h2>
          </div>
            <p class="text-justify">Mewujudkan generasi tahfidz muda yang cinta Al-Qur’an, berakhlakul karimah, berwawasan modern, dan mampu mengamalkan nilai-nilai Al-Qur’an dalam kehidupan bermasyarakat.</p>
        </div>

        <div class="bg-white shadow w-full rounded-lg p-12 text-slate-800">
          <div class="flex items-center gap-3 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
            </svg>

            <h2 class="text-3xl font-bold">Misi</h2>
          </div>
            <p class="text-justify">Menyelenggarakan pendidikan tahfidz Al-Qur’an yang terarah dan mutqin dengan bimbingan pengajar yang berdedikasi, menanamkan pemahaman dasar tafsir serta nilai-nilai Al-Qur’an, membentuk santri yang berakhlakul karimah, disiplin, dan bertanggung jawab, serta mengintegrasikan pendidikan pesantren dengan wawasan modern agar santri mampu mengamalkan Al-Qur’an dalam kehidupan dan siap menghadapi tantangan zaman.</p>
        </div>

      </div>
    </section>
    {{-- ./Tentang Pondok Section --}}

    {{-- Kontak Section --}}
    <section id="contact" class="pb-16 px-8 sm:px-16">
      <h3 class="text-3xl font-bold mb-6 text-center">Kontak Kami</h3>
      <div class="flex flex-col md:flex-row gap-4 mb-4 sm:mx-auto sm:w-full">
          <div class="bg-white shadow w-full h-24 rounded-lg p-4 flex items-center gap-4 text-slate-800 mb-2">
            <i class="fa-brands fa-whatsapp fa-2xl text-pink-600"></i>
            <div class="flex flex-col">
              <h3 class="text-lg font-semibold">Nomor WhatsApp</h3>
              <p class="">+62 812 1234 4568</p>
            </div>
          </div>
          <div class="bg-white shadow w-full h-24 rounded-lg p-4 flex items-center gap-4 text-slate-800 mb-2">
            <i class="fa-regular fa-envelope fa-2xl text-pink-600"></i>
            <div class="flex flex-col">
              <h3 class="text-lg font-semibold">Email</h3>
              <p class="">daruttafsir@gmail.com</p>
            </div>
          </div>
          <div class="bg-white shadow w-full h-24 rounded-lg p-4 flex items-center gap-4 text-slate-800 mb-2">
            <i class="fa-regular fa-map fa-2xl text-pink-600"></i>
            <div class="flex flex-col">
              <h3 class="text-lg font-semibold">Alamat Pondok Pesantren</h3>
              <p class="text-xs sm:text-sm">Jl. Kp. Cemp., Cilangkap, Kec. Kalanganyar, Kabupaten Lebak, Banten 42312</p>
            </div>
        </div>
      </div>

      <div>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.2864245057604!2d106.231561!3d-6.3569588999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e42171eff7fba47%3A0x8fb5428daf4af134!2sDarut%20Tafsir%20Homeschooling%20And%20Tahfidz%20Al-Quran!5e0!3m2!1sid!2sid!4v1764941386114!5m2!1sid!2sid" height="380" class="w-full shadow-lg mx-auto sm:mx-0 rounded-lg" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    {{-- ./Kontak Section --}}
  </div>
  {{-- ./Main Content --}}

  {{-- Footer --}}
  <section>
    <div>
      <footer class="bg-slate-900 text-white py-4 sm:py-16 mt-12 flex flex-col sm:flex-row gap-4 justify-between px-8 sm:px-16">
        <div class="flex gap-8">
          <div class="flex flex-col gap-1">
            <h3 class="font-bold">Quick Link</h3>
            <a href="#" class="hover:text-pink-600">Home</a>
            <a href="#about" class="hover:text-pink-600">Tentang Pondok</a>
            <a href="#contact" class="hover:text-pink-600">Kontak</a>
          </div>
          <div class="flex flex-col gap-1">
            <h3 class="font-bold">Social</h3>
            <a href="https://instagram.com/darut_tafsir?igshid=xeuv6jzjof35" class="hover:text-pink-600" target="_blank">Instagram</a>
            <a href="https://www.facebook.com/profile.php?id=100055205284844" class="hover:text-pink-600" target="_blank">Facebook</a>
            <a href="https://www.youtube.com/channel/UCdRExEmX8Nb2HggOnU6wvvw/featured" class="hover:text-pink-600" target="_blank">Youtube</a>
            <a href="https://www.tiktok.com/@daruttafsir_official?lang=id-id" class="hover:text-pink-600" target="_blank">TikTok</a>
          </div>
        </div>
        <div class="font-light text-xs sm:text-sm sm:self-end">
          &copy; 2025 | All Right Reserved by Darut Tafsir.
        </div>
      </footer>
    </div>
  </section>
  {{-- ./Footer --}}

<script>
  const navbar = document.getElementById('navbar');
  const links = document.querySelectorAll('.home, .about, .contact');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
      navbar.classList.add('bg-slate-900', 'shadow-lg', 'transition', 'duration-300');
    } else {
      navbar.classList.remove('bg-slate-900', 'shadow-lg', 'transition', 'duration-300');
    }
  });

  links.forEach(link => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href');

      if (href === "#") {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      links.forEach(l => l.classList.remove('text-pink-600', 'font-bold'));
      link.classList.add('text-pink-600', 'font-bold');
    });
  });
</script>



</body>
</html>
