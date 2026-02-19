document.addEventListener('DOMContentLoaded', () => {
  const menuBtn = document.querySelector('header button.md\\:hidden');
  if (!menuBtn) return;

  const mobileNav = document.createElement('div');
  mobileNav.className = 'fixed inset-0 bg-white z-[60] p-6 md:p-8 flex flex-col overflow-y-auto hidden animate__animated';
  mobileNav.innerHTML = `
      <div class="flex justify-between items-center mb-8">
         <a href="index.html" class="flex items-center">
          <img src="./images/logo.svg" alt="Logo" class="w-14 md:w-16" />
        </a>
        <button class="close-menu text-secondary">
           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <nav class="flex-1 flex flex-col gap-4 md:gap-6 text-xl md:text-2xl font-bold text-secondary">
        <a href="index.html" class="nav-home">Ana Səhifə</a>
        <a href="about.html" class="nav-about">Haqqımızda</a>
        <a href="stores.html" class="nav-stores">Mağazalar</a>
        <a href="blogs.html" class="nav-blogs">Bloq</a>
        <a href="contact.html" class="nav-contact">Əlaqə</a>
        <div class="mt-6 pt-6 border-t border-slate-100 flex flex-col gap-3">
           <a href="login.html" class="w-full py-3 md:py-4 text-center rounded-xl md:rounded-2xl border-2 border-primary text-primary text-base md:text-lg">Daxil ol</a>
           <a href="register.html" class="w-full py-3 md:py-4 text-center rounded-xl md:rounded-2xl bg-primary text-white text-base md:text-lg">Qeydiyyat</a>
        </div>

         <div class="mt-auto pt-8 pb-4">
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Dil seçimi</p>
            <div class="flex gap-4">
              <a href="#" class="lang-option flex flex-col items-center gap-2 flex-1 p-3 bg-slate-50 rounded-xl border-2 border-primary transition-all">
                <img src="https://flagcdn.com/w40/az.png" class="w-6 md:w-8 h-auto rounded-sm shadow-sm" alt="AZ">
                <span class="text-xs font-bold text-secondary">AZ</span>
              </a>
              <a href="#" class="lang-option flex flex-col items-center gap-2 flex-1 p-3 bg-slate-50/50 rounded-xl border-2 border-transparent hover:border-slate-200 transition-all">
                <img src="https://flagcdn.com/w40/gb.png" class="w-6 md:w-8 h-auto rounded-sm shadow-sm" alt="EN">
                <span class="text-xs font-bold text-slate-400">EN</span>
              </a>
              <a href="#" class="lang-option flex flex-col items-center gap-2 flex-1 p-3 bg-slate-50/50 rounded-xl border-2 border-transparent hover:border-slate-200 transition-all">
                <img src="https://flagcdn.com/w40/ru.png" class="w-6 md:w-8 h-auto rounded-sm shadow-sm" alt="RU">
                <span class="text-xs font-bold text-slate-400">RU</span>
              </a>
            </div>
         </div>
      </nav>
    `;
  document.body.appendChild(mobileNav);

  menuBtn.addEventListener('click', () => {
    mobileNav.classList.remove('hidden', 'animate__fadeOutDown');
    mobileNav.classList.add('animate__fadeInUp');
    document.body.style.overflow = 'hidden';
  });

  const closeMenu = () => {
    mobileNav.classList.remove('animate__fadeInUp');
    mobileNav.classList.add('animate__fadeOutDown');
    document.body.style.overflow = '';
    setTimeout(() => mobileNav.classList.add('hidden'), 500);
  };

  mobileNav.querySelector('.close-menu').addEventListener('click', closeMenu);


  const path = window.location.pathname;
  const page = path.split("/").pop();
  if (page === 'index.html' || page === '') mobileNav.querySelector('.nav-home').classList.add('text-primary');
  else if (page === 'about.html') mobileNav.querySelector('.nav-about').classList.add('text-primary');
  else if (page === 'stores.html' || page === 'single-store.html') mobileNav.querySelector('.nav-stores').classList.add('text-primary');
  else if (page === 'blogs.html' || page === 'single-blog.html') mobileNav.querySelector('.nav-blogs').classList.add('text-primary');
  else if (page === 'contact.html') mobileNav.querySelector('.nav-contact').classList.add('text-primary');
  const langOptions = mobileNav.querySelectorAll('.lang-option');
  langOptions.forEach(option => {
    option.addEventListener('click', (e) => {
      e.preventDefault();
      // Reset all options
      langOptions.forEach(opt => {
        opt.classList.remove('border-primary', 'bg-slate-50', 'border-opacity-100');
        opt.classList.add('border-transparent', 'bg-slate-50/50');
        opt.querySelector('span').classList.remove('text-secondary');
        opt.querySelector('span').classList.add('text-slate-400');
      });

      // Activate clicked option
      option.classList.remove('border-transparent', 'bg-slate-50/50');
      option.classList.add('border-primary', 'bg-slate-50', 'border-opacity-100');
      option.querySelector('span').classList.remove('text-slate-400');
      option.querySelector('span').classList.add('text-secondary');
    });
  });
});
