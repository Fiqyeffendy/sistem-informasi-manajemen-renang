// ═══════════════════════════════════
//  Auth – Login & Logout
// ═══════════════════════════════════

(function () {
  const STORAGE_KEY = 'simpel-fella-user-role';
  const ROLES = {
    admin:   { name: 'Admin Fella',   label: 'Administrator', avatar: 'AF', section: 'dashboard-admin',   nav: 'nav-admin',   route: '/admin/dashboard' },
    pelatih: { name: 'Rizal Maulana', label: 'Pelatih',       avatar: 'RM', section: 'dashboard-pelatih', nav: 'nav-pelatih', route: '/pelatih/dashboard' },
    siswa:   { name: 'Ahmad Fauzi',   label: 'Siswa',         avatar: 'AS', section: 'dashboard-siswa',   nav: 'nav-siswa',   route: '/siswa/dashboard' },
  };

  function resolveRoleFromPath(pathname = window.location.pathname) {
    if (!pathname) return null;
    if (pathname.startsWith('/admin')) return 'admin';
    if (pathname.startsWith('/pelatih')) return 'pelatih';
    if (pathname.startsWith('/siswa')) return 'siswa';
    return null;
  }

  function getStoredRole() {
    try {
      const stored = localStorage.getItem(STORAGE_KEY);
      return stored && ROLES[stored] ? stored : null;
    } catch (error) {
      return null;
    }
  }

  function persistRole(role) {
    try {
      localStorage.setItem(STORAGE_KEY, role);
    } catch (error) {
      // ignore storage errors
    }
  }

  function applyRole(role) {
    const normalizedRole = role && ROLES[role] ? role : 'siswa';
    const r = ROLES[normalizedRole];

    const sidebarName = document.getElementById('sidebar-user-name');
    const sidebarRole = document.getElementById('sidebar-user-role');
    const avatar = document.getElementById('user-avatar-text');

    if (sidebarName) sidebarName.textContent = r.name;
    if (sidebarRole) sidebarRole.textContent = r.label;
    if (avatar) avatar.textContent = r.avatar;

    ['nav-admin', 'nav-pelatih', 'nav-siswa'].forEach(n => {
      const el = document.getElementById(n);
      if (el) el.style.display = (n === r.nav ? 'block' : 'none');
    });

    const loginPage = document.getElementById('page-login');
    const shell = document.getElementById('app-shell');
    const isLoginPage = window.location.pathname === '/' || window.location.pathname === '/login';

    if (loginPage) {
      loginPage.classList.toggle('active', isLoginPage);
      loginPage.style.display = isLoginPage ? 'flex' : 'none';
    }

    if (shell) {
      shell.style.display = isLoginPage ? 'none' : 'flex';
      shell.classList.toggle('active', !isLoginPage);
    }

    if (window.setTopbarDate) window.setTopbarDate();
  }

  function doLogin() {
    const btn = document.getElementById('btn-login');
    const emailEl = document.getElementById('inp-email');
    const passEl = document.getElementById('inp-pass');

    const email = (emailEl?.value || '').trim().toLowerCase();
    const pass = (passEl?.value || '');

    if (!email) {
      if (window.showToast) window.showToast('Masukkan email terlebih dahulu', 'danger');
      return;
    }

    if (!pass || pass.length < 6) {
      if (window.showToast) window.showToast('Password minimal 6 karakter', 'danger');
      return;
    }

    if (btn) {
      btn.disabled = true;
      const oldText = btn.getAttribute('data-old-text') || btn.innerHTML;
      btn.setAttribute('data-old-text', oldText);
      btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...`;
    }

    const finish = () => {
      let role = 'siswa';
      if (email.includes('admin@')) role = 'admin';
      else if (email.includes('pelatih@')) role = 'pelatih';

      const r = ROLES[role];
      persistRole(role);
      applyRole(role);

      if (btn) {
        const oldText = btn.getAttribute('data-old-text');
        btn.disabled = false;
        if (oldText) btn.innerHTML = oldText;
        btn.removeAttribute('data-old-text');
      }

      if (window.showToast) window.showToast(`Selamat datang, ${r.label}!`, 'success');

      if (r.route) {
        setTimeout(() => {
          window.location.assign(r.route);
        }, 250);
      }
    };

    setTimeout(finish, 550);
  }

  function doLogout() {
    try {
      localStorage.removeItem(STORAGE_KEY);
    } catch (error) {
      // ignore storage errors
    }

    const shell = document.getElementById('app-shell');
    if (shell) {
      shell.style.display = 'none';
      shell.classList.remove('active');
    }

    const loginPage = document.getElementById('page-login');
    if (loginPage) {
      loginPage.style.display = 'flex';
      loginPage.classList.add('active');
    }

    window.location.assign('/login');
  }

  function togglePass() {
    const inp = document.getElementById('inp-pass');
    const icon = document.getElementById('eye-icon');
    if (!inp || !icon) return;

    if (inp.type === 'password') {
      inp.type = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      inp.type = 'password';
      icon.className = 'bi bi-eye';
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const role = getStoredRole() || resolveRoleFromPath(window.location.pathname);
    if (role) {
      applyRole(role);
    }
  });

  window.ROLES = ROLES;
  window.doLogin = doLogin;
  window.doLogout = doLogout;
  window.togglePass = togglePass;
})();
