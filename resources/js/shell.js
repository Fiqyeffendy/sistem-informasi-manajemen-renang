// ═══════════════════════════════════
//  App Shell – Navigation & Sidebar
// ═══════════════════════════════════

(function () {
  const SECTION_TITLES = {
    'dashboard-admin'   : 'Dashboard Admin',
    'data-siswa'        : 'Data Siswa',
    'data-pelatih'      : 'Data Pelatih',
    'jadwal'            : 'Jadwal Latihan',
    'presensi'          : 'Presensi',
    'sesi'              : 'Sesi Latihan',
    'laporan'           : 'Laporan',
    'dashboard-pelatih' : 'Dashboard Pelatih',
    'jadwal-pelatih'    : 'Jadwal Saya',
    'siswa-pelatih'     : 'Daftar Siswa',
    'input-presensi'    : 'Input Presensi',
    'dashboard-siswa'   : 'Beranda',
    'jadwal-siswa'      : 'Jadwal Latihan',
    'riwayat-presensi'  : 'Riwayat Presensi',
    'sesi-siswa'        : 'Sisa Sesi',
  };

  /**
   * Switch the visible section and update the active nav link.
   * @param {string} sectionId  – id of the <div class="section"> to show
   * @param {string} navId      – id of the <nav> whose links should be updated
   */
  function showSection(sectionId, navId) {
    document.querySelectorAll('.section').forEach(s => {
      s.style.display = 'none';
      s.classList.remove('fade-in');
    });

    const role = localStorage.getItem('simpel-fella-user-role') || 'siswa';
    const roleNavMap = {
      admin: 'nav-admin',
      pelatih: 'nav-pelatih',
      siswa: 'nav-siswa'
    };
    const navToShow = roleNavMap[role] || 'nav-siswa';

    ['nav-admin', 'nav-pelatih', 'nav-siswa'].forEach(id => {
      const nav = document.getElementById(id);
      if (nav) nav.style.display = (id === navToShow ? 'block' : 'none');
    });

    const target = document.getElementById(sectionId);
    if (target) {
      target.style.display = '';
      target.classList.add('fade-in');
    }

    if (navId) {
      document.querySelectorAll(`#${navId} .nav-link`).forEach(l => l.classList.remove('active'));
      // Robust active-link selection tanpa parsing attribute onclick
      const activeLink = document.querySelector(`#${navId} .nav-link[data-section="${sectionId}"]`);
      if (activeLink) activeLink.classList.add('active');
    }

    const titleEl = document.getElementById('topbar-title');
    if (titleEl) titleEl.textContent = SECTION_TITLES[sectionId] || sectionId;

    closeSidebar();
  }

  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (sidebar) sidebar.classList.toggle('open');
    if (overlay) overlay.classList.toggle('open');
  }

  function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('open');
  }

  function setTopbarDate() {
    const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    // Support both id and class name used in app.blade
    const dateEl = document.getElementById('topbar-date')
               || document.querySelector('.topbar-badge-date');
    if (dateEl) {
      dateEl.textContent = new Date().toLocaleDateString('id-ID', opts);
    }
  }

  window.SECTION_TITLES = SECTION_TITLES;
  window.showSection = showSection;
  window.toggleSidebar = toggleSidebar;
  window.closeSidebar = closeSidebar;
  window.setTopbarDate = setTopbarDate;
})();
