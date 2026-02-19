<!DOCTYPE html>
<html lang="az">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QR Endirim - Endirimli Alış-verişin Yeni Yolu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ request()->getBaseUrl() }}/template/styles/main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { DEFAULT: '#ff5f00', hover: '#e65600', light: '#fff4e5' },
            secondary: { DEFAULT: '#0a2a66', dark: '#071d47' },
          },
          fontFamily: { sans: ['Inter', 'sans-serif'] },
          boxShadow: {
            'orange': '0 10px 15px -3px rgba(255, 95, 0, 0.3)',
            'premium': '0 20px 50px -12px rgba(0, 0, 0, 0.1)',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-white text-slate-800 antialiased gradient-bg">

  <header class="fixed top-0 left-0 w-full z-50 glass border-b border-orange-100">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <a href="{{ route('home') }}" class="flex items-center group">
        <img src="{{ request()->getBaseUrl() }}/template/images/logo.svg" alt="Logo" class="w-32 transition-transform" />
      </a>


      <nav class="hidden md:flex items-center gap-8">
        <a href="{{ route('home') }}" class="nav-link-active hover:text-primary transition-colors text-lg">Ana Səhifə</a>
        <a href="{{ route('services.index') }}" class="hover:text-primary transition-colors text-lg text-slate-600">Haqqımızda</a>
        <a href="{{ route('shops.index') }}" class="hover:text-primary transition-colors text-lg text-slate-600">Mağazalar</a>
        <a href="{{ route('blogs.index') }}" class="hover:text-primary transition-colors text-lg text-slate-600">Bloq</a>
        <a href="{{ route('services.index') }}" class="hover:text-primary transition-colors text-lg text-slate-600">Əlaqə</a>
      </nav>

      <div class="flex items-center gap-4">
        <div class="hidden lg:block relative w-48 xl:w-64 mr-2">
          <input type="text" placeholder="Mağaza axtar..."
            class="w-full pl-10 pr-4 py-2.5 rounded-full border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 text-sm text-slate-600 font-medium placeholder:font-normal" />
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </div>

        <div class="hidden md:block relative group lang-switcher">
          <button
            class="flex items-center gap-2 px-3 py-2.5 rounded-full border border-slate-200 bg-white hover:border-primary transition-all duration-300">
            <img src="https://flagcdn.com/w20/az.png" class="w-5 h-auto rounded-sm" alt="AZ">
            <span class="text-sm font-bold text-slate-700">AZ</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
              stroke="currentColor" class="w-3.5 h-3.5 text-slate-400 group-hover:text-primary transition-colors">
              <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
          </button>
          <div
            class="absolute top-full right-0 mt-2 w-32 bg-white rounded-2xl shadow-premium border border-slate-100 py-2 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
            <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors">
              <img src="https://flagcdn.com/w20/az.png" class="w-5 h-auto rounded-sm" alt="AZ">
              <span class="text-sm font-bold text-slate-700">AZ</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors">
              <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm" alt="EN">
              <span class="text-sm font-medium text-slate-600">EN</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-slate-50 transition-colors">
              <img src="https://flagcdn.com/w20/ru.png" class="w-5 h-auto rounded-sm" alt="RU">
              <span class="text-sm font-medium text-slate-600">RU</span>
            </a>
          </div>
        </div>

        <a href="{{ route('login') }}"
          class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 rounded-full border-2 border-primary text-primary font-semibold hover:bg-primary hover:text-white transition-all duration-300">
          Daxil ol
        </a>
        <a href="{{ route('register') }}"
          class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-primary text-white font-semibold shadow-orange hover:bg-primary-hover transition-all duration-300">
          Qeydiyyat
        </a>

        <button class="md:hidden text-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
    </div>
  </header>

  <main class="pt-24">

    <section class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center py-20">
      <div class="animate__animated animate__fadeInLeft">
        <h1 class="text-4xl md:text-7xl font-extrabold text-secondary leading-[1.1] mb-6">
          Alış-verişdə <br />
          <span class="text-primary">Yeni Dövr</span> Başladı
        </h1>
        <p class="text-xl text-slate-600 mb-10 max-w-lg leading-relaxed">
          Sevdiyiniz mağazalardan QR kodla anında endirim qazanın. Sürətli, asan və tamamilə rəqəmsal endirim təcrübəsi!
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="{{ route('register') }}"
            class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-primary text-white text-lg font-bold shadow-orange hover:bg-primary-hover transition-all duration-300">
            Həmən Başla
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
              stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
          </a>
          <a href="{{ route('shops.index') }}"
            class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full border-2 border-slate-200 text-secondary text-lg font-bold hover:bg-slate-50 transition-all duration-300">
            Mağazaları Gör
          </a>
        </div>


        <div class="flex gap-8 mt-16 pt-8 border-t border-slate-100">
          <div>
            <p class="text-3xl font-bold text-secondary">50k+</p>
            <p class="text-slate-500">İstifadəçi</p>
          </div>
          <div>
            <p class="text-3xl font-bold text-secondary">100+</p>
            <p class="text-slate-500">Partnyor</p>
          </div>
          <div>
            <p class="text-3xl font-bold text-secondary">25%</p>
            <p class="text-slate-500">Orta Qənaət</p>
          </div>
        </div>
      </div>

      <div class="relative animate__animated animate__fadeInRight">
        <div
          class="relative z-10 rounded-2xl overflow-hidden shadow-2xl bg-secondary/5 border border-white/20 backdrop-blur-sm p-4">
          <img src="{{ request()->getBaseUrl() }}/template/images/homepage/hero-modern.png" alt="Hero"
            class="hidden md:block w-full h-auto rounded-xl shadow-premium" />
        </div>

        <div
          class="hidden md:block absolute -top-10 -right-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl animate-pulse">
        </div>
        <div
          class="hidden md:block absolute -bottom-10 -left-10 w-60 h-60 bg-blue-500/10 rounded-full blur-3xl animate-pulse">
        </div>
      </div>
    </section>

    <section class="py-20 overflow-hidden">
      <div class="container mx-auto px-4">
        <div class="flex flex-col items-center mb-12">
          <span
            class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-4">Şəbəkəmiz</span>
          <h2 class="text-3xl font-bold text-secondary text-center">Etibar Edən Partnyorlarımız</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
          <div
            class="group bg-white p-6 rounded-lg border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex items-center justify-center h-48">
            <img src="{{ request()->getBaseUrl() }}/template/images/stores/bravo.jpg" alt="Bravo"
              class="h-32 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500" />
          </div>
          <div
            class="group bg-white p-6 rounded-lg border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex items-center justify-center h-48">
            <img src="{{ request()->getBaseUrl() }}/template/images/stores/neptun.jpg" alt="Neptun"
              class="h-32 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500" />
          </div>
          <div
            class="group bg-white p-6 rounded-lg border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex items-center justify-center h-48">
            <img src="{{ request()->getBaseUrl() }}/template/images/stores/irsad.jpg" alt="Irshad"
              class="h-32 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500" />
          </div>
          <div
            class="group bg-white p-6 rounded-lg border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex items-center justify-center h-48">
            <img src="{{ request()->getBaseUrl() }}/template/images/stores/zara.jpg" alt="Zara"
              class="h-32 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500" />
          </div>
        </div>
      </div>
    </section>


    <section class="py-24">
      <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-20">
          <h2 class="text-4xl font-extrabold mb-6">Niyə Məhz <span class="text-primary tracking-tight">QREndirim?</span>
          </h2>
          <p class="text-xl text-slate-600">Sizin qənaətiniz və rahatlığınız üçün ən müasir texnologiyadan istifadə
            edirik.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
          <div
            class="group bg-white p-10 rounded-3xl border border-slate-100 shadow-premium hover:shadow-2xl transition-all duration-500">
            <div
              class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center mb-8 border border-orange-100 group-hover:bg-primary transition-all duration-500 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                class="w-8 h-8 text-primary group-hover:text-white transition-colors duration-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-secondary">Sürətli və Asan</h3>
            <p class="text-slate-600 text-lg leading-relaxed">Artıq plastik kartlara ehtiyac yoxdur. Sadəcə QR kodu skan
              edin və endiriminiz anında tətbiq olunsun.</p>
          </div>

          <div
            class="group bg-white p-10 rounded-3xl border border-slate-100 shadow-premium hover:shadow-2xl transition-all duration-500">
            <div
              class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mb-8 border border-blue-100 group-hover:bg-secondary transition-all duration-500 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                class="w-8 h-8 text-secondary group-hover:text-white transition-colors duration-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615 3.001 3.001 0 0 0 3.75-.615 3.001 3.001 0 0 0 3.75.615m-15 0-1.033 3.9a.75.75 0 0 0 .726.95h.75a.75.75 0 0 0 .75-.75V11.25m3.75 0v3.75a.75.75 0 0 0 .75.75h.75a.75.75 0 0 0 .75-.75V11.25m3.75 0v3.75a.75.75 0 0 0 .75.75h.75a.75.75 0 0 0 .75-.75V11.25" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-secondary">Geniş Şəbəkə</h3>
            <p class="text-slate-600 text-lg leading-relaxed">Ölkənin ən məşhur supermarketləri, geyim dükanları və
              texnika mağazaları artıq bizim partnyorumuzdur.</p>
          </div>

          <div
            class="group bg-white p-10 rounded-3xl border border-slate-100 shadow-premium hover:shadow-2xl transition-all duration-500">
            <div
              class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center mb-8 border border-green-100 group-hover:bg-green-600 transition-all duration-500 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                class="w-8 h-8 text-green-600 group-hover:text-white transition-colors duration-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75m0 1.5v.75m0 1.5v.75m0 1.5V15m1.5 1.5h1.5m1.5 0h1.5m1.5 0h1.5m1.5 0H15m-1.5-13.5v.75m0 1.5v.75m0 1.5v.75m0 1.5V15m1.5 1.5h1.5m1.5 0h1.5m1.5 0h1.5m1.5 0H15m0-12a1.5 1.5 0 0 1 1.5 1.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-1.5a1.5 1.5 0 0 1-1.5-1.5v-1.5a1.5 1.5 0 0 1 1.5-1.5H15Z" />
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-4 text-secondary">Maksimum Qənaət</h3>
            <p class="text-slate-600 text-lg leading-relaxed">Xüsusi paketlərimizlə hər alış-verişdə daha çox
              qazanacaqsınız. Cibinizə sevinəcəksiniz!</p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-24 bg-slate-50/50">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-12">
          <div>
            <span
              class="bg-orange-50 text-primary border border-orange-100 px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest mb-4 inline-block">Populyar</span>
            <h2 class="text-4xl font-extrabold text-secondary">Seçilmiş <span class="text-primary">Mağazalar</span></h2>
          </div>
          <div class="flex items-center gap-4">
            <a href="{{ route('shops.index') }}"
              class="hidden sm:flex items-center gap-2 text-primary font-bold hover:gap-3 transition-all mr-8">
              Hamısına bax
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </a>
            <div class="flex gap-2">
              <button
                class="swiper-prev-btn w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:border-primary hover:text-primary transition-all bg-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </button>
              <button
                class="swiper-next-btn w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:border-primary hover:text-primary transition-all bg-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="swiper stores-swiper -mx-4 sm:mx-0 sm:px-0 !pb-12">
          <div class="swiper-wrapper py-6">
            <div class="swiper-slide">
              <div
                class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                <div class="relative h-52 overflow-hidden">
                  <img src="{{ request()->getBaseUrl() }}/template/images/stores/bravo.jpg"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    alt="Bravo" />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                  <div class="absolute bottom-6 left-6 flex items-center gap-2">
                    <span class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full">20% Endirim</span>
                  </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                  <div class="flex items-start justify-between mb-4">
                    <div>
                      <h3 class="text-2xl font-bold group-hover:text-primary transition-colors">Bravo</h3>
                      <span class="text-slate-400 font-medium">Supermarket</span>
                    </div>
                    <div
                      class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-primary transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                      </svg>
                    </div>
                  </div>
                  <p class="text-slate-600 mb-8 line-clamp-2">BRAVO-da super təklifləri qaçırmayın! Geniş çeşidli
                    məhsullar
                    və keyfiyyətli xidmət.</p>
                  <a href="{{ route('shops.index') }}"
                    class="mt-auto w-full py-4 rounded-xl bg-secondary text-white font-bold text-center hover:bg-secondary-dark transition-all">Mağazaya
                    bax</a>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div
                class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                <div class="relative h-52 overflow-hidden">
                  <img src="{{ request()->getBaseUrl() }}/template/images/stores/neptun.jpg"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    alt="Neptun" />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                  <div class="absolute bottom-6 left-6 flex items-center gap-2">
                    <span class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full">15% Endirim</span>
                  </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                  <div class="flex items-start justify-between mb-4">
                    <div>
                      <h3 class="text-2xl font-bold group-hover:text-primary transition-colors">Neptun</h3>
                      <span class="text-slate-400 font-medium">Supermarket</span>
                    </div>
                    <div
                      class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-primary transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                      </svg>
                    </div>
                  </div>
                  <p class="text-slate-600 mb-8 line-clamp-2">Super təklifləri qaçırmayın! Təzə ərzaq və geniş çeşid.
                  </p>
                  <a href="{{ route('shops.index') }}"
                    class="mt-auto w-full py-4 rounded-xl bg-secondary text-white font-bold text-center hover:bg-secondary-dark transition-all">Mağazaya
                    bax</a>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div
                class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                <div class="relative h-52 overflow-hidden">
                  <img src="{{ request()->getBaseUrl() }}/template/images/stores/irsad.jpg"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    alt="Irshad" />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                  <div class="absolute bottom-6 left-6 flex items-center gap-2">
                    <span class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full">20% Endirim</span>
                  </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                  <div class="flex items-start justify-between mb-4">
                    <div>
                      <h3 class="text-2xl font-bold group-hover:text-primary transition-colors">İrşad</h3>
                      <span class="text-slate-400 font-medium">Elektronika</span>
                    </div>
                    <div
                      class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-primary transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                      </svg>
                    </div>
                  </div>
                  <p class="text-slate-600 mb-8 line-clamp-2">Sənə uyğun mağaza! Ən son texnologiyalar və sərfəli
                    şərtlər.
                  </p>
                  <a href="{{ route('shops.index') }}"
                    class="mt-auto w-full py-4 rounded-xl bg-secondary text-white font-bold text-center hover:bg-secondary-dark transition-all">Mağazaya
                    bax</a>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div
                class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                <div class="relative h-52 overflow-hidden">
                  <img src="{{ request()->getBaseUrl() }}/template/images/stores/zara.jpg"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    alt="Zara" />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                  <div class="absolute bottom-6 left-6 flex items-center gap-2">
                    <span class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full">15% Endirim</span>
                  </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                  <div class="flex items-start justify-between mb-4">
                    <div>
                      <h3 class="text-2xl font-bold group-hover:text-primary transition-colors">Zara</h3>
                      <span class="text-slate-400 font-medium">Geyim</span>
                    </div>
                    <div
                      class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-primary transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                      </svg>
                    </div>
                  </div>
                  <p class="text-slate-600 mb-8 line-clamp-2">Ən yeni kolleksiyalar və eksklüziv təkliflər Zara-da.</p>
                  <a href="{{ route('shops.index') }}"
                    class="mt-auto w-full py-4 rounded-xl bg-secondary text-white font-bold text-center hover:bg-secondary-dark transition-all">Mağazaya
                    bax</a>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div
                class="group bg-white rounded-2xl border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                <div class="relative h-52 overflow-hidden">
                  <img src="{{ request()->getBaseUrl() }}/template/images/stores/ali-nino.jpg"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    alt="Ali & Nino" />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                  <div class="absolute bottom-6 left-6 flex items-center gap-2">
                    <span class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full">10% Endirim</span>
                  </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                  <div class="flex items-start justify-between mb-4">
                    <div>
                      <h3 class="text-2xl font-bold group-hover:text-primary transition-colors">Ali & Nino</h3>
                      <span class="text-slate-400 font-medium">Kitab evi</span>
                    </div>
                    <div
                      class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-primary transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                      </svg>
                    </div>
                  </div>
                  <p class="text-slate-600 mb-8 line-clamp-2">Kitabsevərlər üçün ən yaxşı ünvan! Minlərlə kitab və
                    maraqlı hədiyyələr.</p>
                  <a href="{{ route('shops.index') }}"
                    class="mt-auto w-full py-4 rounded-xl bg-secondary text-white font-bold text-center hover:bg-secondary-dark transition-all">Mağazaya
                    bax</a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination !bottom-0"></div>
        </div>

        <div class="mt-12 text-center sm:hidden">
          <a href="{{ route('shops.index') }}"
            class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white border border-slate-200 text-secondary font-bold hover:bg-slate-50 transition-all">
            Hamısına bax
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
          </a>
        </div>
      </div>
    </section>


    <section class="bg-secondary py-24 lg:rounded-lg sm:mx-4 overflow-hidden relative">

      <div
        class="hidden md:block absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -mr-64 -mt-64">
      </div>
      <div
        class="hidden md:block absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-500/10 rounded-full blur-[100px] -ml-48 -mb-48">
      </div>

      <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-20">
          <h2 class="text-4xl font-extrabold mb-6 text-white">Sizə Uyğun <span class="text-primary italic">Paketi</span>
            Seçin</h2>
          <p class="text-xl text-slate-300">Hər kəsin ehtiyacına uyğun hazırlanmış xüsusi tariflər</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 items-end">

          <div
            class="bg-white/5 backdrop-blur-md p-10 rounded-3xl border border-white/10 flex flex-col hover:bg-white/10 transition-all duration-300">
            <h3 class="text-white text-2xl font-bold mb-2">Başlanğıc</h3>
            <div class="mb-8">
              <span class="text-white text-5xl font-extrabold">0</span>
              <span class="text-slate-400 text-xl">₼ / pulsuz</span>
            </div>
            <ul class="space-y-4 mb-10">
              <li class="flex items-center gap-3 text-slate-300">
                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-3 h-3 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                  </svg>
                </div>
                5 İstifadə haqqı
              </li>
              <li class="flex items-center gap-3 text-slate-300">
                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-3 h-3 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                  </svg>
                </div>
                Bütün mağazalarda keçərli
              </li>
              <li class="flex items-center gap-3 text-slate-500 line-through">
                Prioritet dəstək
              </li>
            </ul>
            <button
              class="w-full py-4 rounded-xl border-2 border-white/20 text-white font-bold hover:bg-white/10 transition-all mt-auto">Həmən
              Başla</button>
          </div>


          <div class="bg-white p-1 shadow-2xl rounded-3xl relative transform translate-y-[-24px] mt-10 md:mt-0">
            <div class="absolute -top-4 inset-x-0 flex justify-center">
              <span
                class="bg-primary text-white px-6 py-1.5 rounded-full text-sm font-bold uppercase tracking-widest">Ən
                Çox Seçilən</span>
            </div>
            <div class="p-10 flex flex-col h-full bg-slate-50 rounded-[22px]">
              <h3 class="text-secondary text-2xl font-bold mb-2">Premium</h3>
              <div class="mb-8">
                <span class="text-secondary text-5xl font-extrabold">15</span>
                <span class="text-slate-500 text-xl font-bold">₼ / aylıq</span>
              </div>
              <ul class="space-y-4 mb-10">
                <li class="flex items-center gap-3 text-slate-700">
                  <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                      stroke="currentColor" class="w-3 h-3 text-primary">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                  </div>
                  Limitiz İstifadə
                </li>
                <li class="flex items-center gap-3 text-slate-700">
                  <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                      stroke="currentColor" class="w-3 h-3 text-primary">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                  </div>
                  Double Endirim balları
                </li>
                <li class="flex items-center gap-3 text-slate-700">
                  <div class="w-5 h-5 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                      stroke="currentColor" class="w-3 h-3 text-primary">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                  </div>
                  Prioritet Dəstək
                </li>
              </ul>
              <button
                class="w-full py-4 rounded-xl bg-primary text-white font-bold shadow-orange hover:bg-primary-hover transition-all mt-auto">Abunə
                Ol</button>
            </div>
          </div>


          <div
            class="bg-white/5 backdrop-blur-md p-10 rounded-3xl border border-white/10 flex flex-col hover:bg-white/10 transition-all duration-300">
            <h3 class="text-white text-2xl font-bold mb-2">Ailə</h3>
            <div class="mb-8">
              <span class="text-white text-5xl font-extrabold">25</span>
              <span class="text-slate-400 text-xl">₼ / aylıq</span>
            </div>
            <ul class="space-y-4 mb-10">
              <li class="flex items-center gap-3 text-slate-300">
                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-3 h-3 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                  </svg>
                </div>
                4 Şəxs üçün Keçərli
              </li>
              <li class="flex items-center gap-3 text-slate-300">
                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-3 h-3 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                  </svg>
                </div>
                Hər şey Daxil
              </li>
              <li class="flex items-center gap-3 text-slate-300">
                <div class="w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="w-3 h-3 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                  </svg>
                </div>
                VIP Tədbirlər
              </li>
            </ul>
            <button
              class="w-full py-4 rounded-xl border-2 border-white/20 text-white font-bold hover:bg-white/10 transition-all mt-auto">Seç</button>
          </div>
        </div>
      </div>
    </section>


    <section class="container mx-auto px-4 py-24">
      <div class="bg-primary/90 p-12 md:p-20 rounded-3xl relative overflow-hidden shadow-2xl">
        <div class="hidden md:block absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl">
        </div>
        <div class="hidden md:block absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full -ml-32 -mb-32 blur-3xl">
        </div>

        <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center text-white">
          <div>
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight text-white">Endirim Dünyasına <br />Giriş
              Edin!</h2>
            <p class="text-xl opacity-90 leading-relaxed">Yeni gələn mağazalardan və xüsusi həftəlik endirimlərdən ilk
              siz xəbərdar olun.</p>
          </div>
          <div class="flex flex-col gap-4">
            <input type="email" placeholder="E-mail ünvanınız"
              class="w-full px-8 py-5 rounded-xl bg-white text-secondary font-semibold focus:outline-none focus:ring-4 focus:ring-white/30 text-lg transition-all" />
            <button
              class="w-full py-5 rounded-xl bg-secondary text-white font-bold text-lg hover:bg-secondary-dark hover:scale-[1.01] transition-all duration-300">
              Abunə Ol və Qazan
            </button>
          </div>
        </div>
      </div>
    </section>
  </main>


  <footer class="bg-white pt-24 pb-12 border-t border-slate-100">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-4 gap-12 mb-16">
        <div class="col-span-2 md:col-span-1">
          <a href="{{ route('home') }}" class="flex items-center mb-6">
            <img src="{{ request()->getBaseUrl() }}/template/images/logo.svg" alt="Logo" class="w-32 transition-transform" />
          </a>
          <p class="text-slate-500 text-lg leading-relaxed">Azərbaycanın ən müasir və sürətli endirim platforması.
            Sevdiyiniz mağazalarda hər zaman sərfəli alış-veriş edin.</p>
        </div>

        <div>
          <h4 class="text-secondary font-bold text-xl mb-6">Keçidlər</h4>
          <ul class="space-y-4">
            <li><a href="{{ route('home') }}" class="text-slate-500 hover:text-primary transition-colors">Ana Səhifə</a></li>
            <li><a href="{{ route('services.index') }}" class="text-slate-500 hover:text-primary transition-colors">Haqqımızda</a></li>
            <li><a href="{{ route('shops.index') }}" class="text-slate-500 hover:text-primary transition-colors">Mağazalar</a></li>
            <li><a href="{{ route('blogs.index') }}" class="text-slate-500 hover:text-primary transition-colors">Bloq</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-secondary font-bold text-xl mb-6">Dəstək</h4>
          <ul class="space-y-4">
            <li><a href="{{ route('services.index') }}" class="text-slate-500 hover:text-primary transition-colors">Tez-tez Verilən
                Suallar</a></li>
            <li><a href="{{ route('services.index') }}" class="text-slate-500 hover:text-primary transition-colors">Qaydalar</a></li>
            <li><a href="{{ route('services.index') }}" class="text-slate-500 hover:text-primary transition-colors">Məxfilik</a></li>
            <li><a href="{{ route('services.index') }}" class="text-slate-500 hover:text-primary transition-colors">Əlaqə</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-secondary font-bold text-xl mb-6">Sosial Media</h4>
          <div class="flex gap-4">
            <a href="#"
              class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
              <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                <path
                  d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.14H7.5V12h2v11.5h5V12h2.82l.45-4.54z" />
              </svg>
            </a>
            <a href="#"
              class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
              <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                <path
                  d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16.35a4.188 4.188 0 110-8.376 4.188 4.188 0 010 8.376zm4.962-10.405a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
              </svg>
            </a>
            <a href="#"
              class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-primary hover:text-white transition-all">
              <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                <path
                  d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505a3.017 3.017 0 00-2.122 2.136C0 8.055 0 12 0 12s0 3.945.501 5.814a3.015 3.015 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.945 24 12 24 12s0-3.945-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
              </svg>
            </a>
          </div>
        </div>
      </div>

      <div class="pt-12 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
        <p class="text-slate-500 font-medium">© 2026 QR Endirim. Bütün hüquqlar qorunur.</p>
        <div class="flex items-center gap-8">
          <span class="text-slate-400 hover:text-primary transition-colors cursor-pointer">Azərbaycan dili</span>
          <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-slate-500">Sistem aktivdir</span>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="{{ request()->getBaseUrl() }}/template/utils/mobile-menu.js"></script>
  <style>
    .stores-swiper .swiper-slide {
      height: auto;
      display: flex;
    }

    .swiper-pagination-bullet-active {
      background: var(--primary) !important;
    }

    .swiper-pagination-bullet {
      width: 10px;
      height: 10px;
      transition: all 0.3s ease;
    }

    .swiper-pagination-bullet-active {
      width: 25px;
      border-radius: 5px;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      new Swiper('.stores-swiper', {
        slidesPerView: 1,
        spaceBetween: 16,
        centeredSlides: true,
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '.swiper-next-btn',
          prevEl: '.swiper-prev-btn',
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
            spaceBetween: 20,
            centeredSlides: false,
          },
          1024: {
            slidesPerView: 4,
            spaceBetween: 24,
            centeredSlides: false,
          }
        }
      });
    });
  </script>
</body>

</html>
