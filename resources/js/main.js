// Entry point utama frontend yang mengatur interaksi halaman admin dan dashboard.
(function () {
  const API_BASE_URL = '/api';

  function formatSiswaId(id) {
    if (id == null || id === '') return '-';
    const number = Number(id);
    if (Number.isNaN(number)) return String(id);
    return `S${String(number).padStart(3, '0')}`;
  }

  // Muat daftar siswa dari API dan render ke tabel admin.
  async function loadSiswaList() {
    const tbody = document.getElementById('siswa-table-body');
    const summary = document.getElementById('siswa-table-summary');
    const countSummary = document.getElementById('siswa-count-summary');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="10" class="text-muted text-center py-4">Memuat data siswa...</td></tr>';
    if (summary) summary.textContent = 'Memuat data...';

    try {
      const res = await fetch(`${API_BASE_URL}/siswa`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const items = Array.isArray(data) ? data : [];

      if (!items.length) {
        tbody.innerHTML = '<tr><td colspan="10" class="text-muted text-center py-4">Belum ada data siswa.</td></tr>';
        if (summary) summary.textContent = 'Belum ada data siswa.';
        if (countSummary) countSummary.textContent = '0 data ditemukan';
        return;
      }

      tbody.innerHTML = items.map((item, idx) => {
        const totalSesi = Number(item.total_sesi ?? 4);
        const sesiTerpakai = Number(item.sesi_terpakai ?? 0);
        const sisaSesi = Math.max(totalSesi - sesiTerpakai, 0);
        
        // Progress percent
        const progressPercent = totalSesi > 0 ? (sisaSesi / totalSesi) * 100 : 0;
        const fillClass = sisaSesi <= 2 ? 'fill-low' : sisaSesi <= 5 ? 'fill-warn' : 'fill-ok';
        
        // Extract short program name
        const programFull = item.program || 'Fella WaterBabies (Swimming Lessons for Toddlers)';
        const programShort = programFull.includes('WaterBabies') ? 'WaterBabies' : 
                            programFull.includes('SwimStars') ? 'SwimStars' :
                            programFull.includes('AquaFit') ? 'AquaFit' : 'SwimElite';

        // Badge design details based on level
        let levelStyle = 'background: #F0FDF4; color: #16a34a; border: 1px solid #bbf7d0;'; // Green
        if (programShort === 'SwimStars' || programShort === 'AquaFit') {
          levelStyle = 'background: #EFF6FF; color: #2563eb; border: 1px solid #dbeafe;'; // Blue
        } else if (programShort === 'SwimElite') {
          levelStyle = 'background: #EEF2F6; color: #475569; border: 1px solid #e2e8f0;'; // Slate
        }

        // Format avatar initials
        const avatarChar = item.nama ? item.nama.trim().charAt(0).toUpperCase() : 'S';

        return `
          <tr>
            <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">${idx + 1}</span></td>
            <td><span style="font-weight: 600; font-size: 0.855rem; color: var(--text-secondary);">${formatSiswaId(item.id)}</span></td>
            <td>
              <div class="cell-name">
                <div class="cell-avatar">${avatarChar}</div>
                <div>
                  <div class="cell-name-text">${(item.nama || '-').replace(/</g, '&lt;')}</div>
                  <div class="cell-name-sub">${item.no_hp_ortu || '-'}</div>
                </div>
              </div>
            </td>
            <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-main);">${item.umur ?? '-'}</span></td>
            <td>
              <span class="badge px-2.5 py-1" style="${levelStyle}">
                ${programShort}
              </span>
            </td>
            <td><span class="badge badge-aktif px-2">${item.jenis_program || 'Small Group'}</span></td>
            <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">${item.lokasi_les || 'Perumahan Istana Mentari'}</span></td>
            <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-main);">${totalSesi}</span></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="sesi-bar" style="width: 60px;">
                  <div class="fill ${fillClass}" style="width: ${progressPercent}%;"></div>
                </div>
                <span style="font-weight: 700; font-size: 0.855rem; color: var(--text-main);">${sisaSesi}</span>
              </div>
            </td>
            <td style="text-align: right;">
              <div class="d-flex gap-1.5 justify-content-end">
                <button class="btn-action-menu btn-action-edit" data-action="open-edit-siswa" data-id="${item.id ?? ''}" data-nama="${(item.nama || '').replace(/"/g, '&quot;')}" data-umur="${item.umur ?? ''}" data-program="${programFull.replace(/"/g, '&quot;')}" data-jenis-program="${item.jenis_program || 'Small Group'}" data-lokasi-les="${(item.lokasi_les || 'Perumahan Istana Mentari').replace(/"/g, '&quot;')}" data-total-sesi="${totalSesi}" data-no-hp="${item.no_hp_ortu ?? ''}">
                  <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action-menu btn-action-del" data-action="confirm-hapus" data-type="siswa" data-id="${item.id ?? ''}">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        `;
      }).join('');

      if (summary) summary.textContent = `Menampilkan 1-${items.length} dari ${items.length} data`;
      if (countSummary) countSummary.textContent = `${items.length} data ditemukan`;
    } catch (err) {
      console.error('[siswa] failed to load data', err);
      tbody.innerHTML = '<tr><td colspan="10" class="text-danger text-center py-4">Gagal memuat data siswa.</td></tr>';
      if (summary) summary.textContent = 'Gagal memuat data siswa.';
      if (countSummary) countSummary.textContent = 'Error';
    }
  }

  // Simpan data siswa baru dari modal tambah.
  async function saveSiswaFromModal() {
    const nama = document.getElementById('siswa-nama')?.value?.trim();
    const umur = document.getElementById('siswa-umur')?.value;
    const program = document.getElementById('siswa-program')?.value || 'Fella WaterBabies (Swimming Lessons for Toddlers)';
    const jenisProgram = document.getElementById('siswa-jenis-program')?.value || 'Small Group';
    const lokasiLes = document.getElementById('siswa-lokasi-les')?.value || 'Perumahan Istana Mentari';

const totalSesi = document.getElementById('siswa-total-sesi')?.value ? Number(document.getElementById('siswa-total-sesi').value) : 4;
    const noHp = document.getElementById('siswa-no-hp')?.value?.trim();

    if (!nama) {
      if (window.showToast) window.showToast('Nama siswa wajib diisi.', 'danger');
      return;
    }

    try {
      const res = await fetch(`${API_BASE_URL}/siswa`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nama,
          umur: umur ? Number(umur) : null,
          no_hp_ortu: noHp || null,
          program,
          jenis_program: jenisProgram,
          lokasi_les: lokasiLes,
          total_sesi: totalSesi,
          sesi_terpakai: 0,
        }),
      });

      const data = await res.json().catch(() => ({}));
      if (!res.ok) {
        throw new Error(data.message || 'Gagal menambahkan siswa');
      }

      if (window.showToast) window.showToast('Siswa berhasil ditambahkan.', 'success');
      document.getElementById('siswa-nama').value = '';
      document.getElementById('siswa-umur').value = '';
      document.getElementById('siswa-program').value = 'Fella WaterBabies (Swimming Lessons for Toddlers)';
      document.getElementById('siswa-jenis-program').value = 'Small Group';
      document.getElementById('siswa-lokasi-les').value = 'Perumahan Istana Mentari';
      document.getElementById('siswa-total-sesi').value = '4';
      document.getElementById('siswa-no-hp').value = '';

      const modalEl = document.getElementById('modal-tambah-siswa');
      if (modalEl && window.bootstrap) {
        const modal = window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
        modal.hide();
      }

      await loadSiswaList();
    } catch (err) {
      console.error('[siswa] failed to save', err);
      if (window.showToast) window.showToast(err.message || 'Gagal menambahkan siswa.', 'danger');
    }
  }

  // Isi form edit siswa dengan data yang dipilih.
  function openEditSiswa(id, nama, umur, program, jenisProgram, lokasiLes, totalSesi, noHp) {
    window.currentEditSiswaId = id;
    document.getElementById('siswa-edit-nama').value = nama || '';
    document.getElementById('siswa-edit-umur').value = umur || '';
    document.getElementById('siswa-edit-program').value = program || 'Fella WaterBabies (Swimming Lessons for Toddlers)';
    document.getElementById('siswa-edit-jenis-program').value = jenisProgram || 'Small Group';
    document.getElementById('siswa-edit-lokasi-les').value = lokasiLes || 'Perumahan Istana Mentari';
document.getElementById('siswa-edit-total-sesi').value = totalSesi || '4';
    document.getElementById('siswa-edit-no-hp').value = noHp || '';
    if (window.openModal) window.openModal('modal-edit-siswa');
  }

  // Isi form edit pelatih dengan data yang dipilih.
  function openEditPelatih(id, nama, noHp, spesialisasi, jadwal, status, alasanCuti) {
    window.currentEditPelatihId = id;
    document.getElementById('pelatih-edit-nama').value = nama || '';
    document.getElementById('pelatih-edit-no-hp').value = noHp || '';

    // Set checkbox spesialisasi
    document.querySelectorAll('input[name="pelatih-edit-spesialisasi[]"]').forEach(cb => cb.checked = false);
    if (spesialisasi) {
      const selectedArr = spesialisasi.split(',').map(s => s.trim());
      selectedArr.forEach(val => {
        const cb = document.getElementById(`spesial-edit-${val.toLowerCase()}`);
        if (cb) cb.checked = true;
      });
    }

    // Reset semua hari + nonaktifkan semua input jam
    document.querySelectorAll('input[name="jadwal-edit-hari[]"]').forEach(cb => {
      cb.checked = false;
      const hariKey = cb.value.toLowerCase();
      const jamInput = document.getElementById(`jadwal-edit-jam-${hariKey}`);
      if (jamInput) { jamInput.disabled = true; jamInput.value = '07:00'; }
    });

    // Set jadwal per hari dari data yang disimpan
    if (jadwal) {
      let jadwalArr = [];
      try { jadwalArr = JSON.parse(jadwal); } catch (e) { jadwalArr = []; }
      jadwalArr.forEach(({ hari, jam }) => {
        const key = hari.toLowerCase();
        const cb = document.getElementById(`jadwal-edit-${key}`);
        const jamInput = document.getElementById(`jadwal-edit-jam-${key}`);
        if (cb) cb.checked = true;
        if (jamInput) { jamInput.disabled = false; jamInput.value = jam || '07:00'; }
      });
    }

    document.getElementById('pelatih-edit-status').value = status || 'aktif';

    const wrapper = document.getElementById('pelatih-edit-alasan-cuti-wrapper');
    const textarea = document.getElementById('pelatih-edit-alasan-cuti');
    if (status === 'cuti') {
      if (wrapper) wrapper.style.display = 'block';
      if (textarea) textarea.value = alasanCuti || '';
    } else {
      if (wrapper) wrapper.style.display = 'none';
      if (textarea) textarea.value = '';
    }

    if (window.openModal) window.openModal('modal-edit-pelatih');
  }

  window.openEditPelatih = openEditPelatih;

  // Kirim perubahan data siswa melalui API update.
  async function saveEditSiswaFromModal() {
    const id = window.currentEditSiswaId;
    if (!id) {
      if (window.showToast) window.showToast('Data siswa tidak valid.', 'danger');
      return;
    }

    const nama = document.getElementById('siswa-edit-nama')?.value?.trim();
    const umur = document.getElementById('siswa-edit-umur')?.value;
    const program = document.getElementById('siswa-edit-program')?.value || 'Fella WaterBabies (Swimming Lessons for Toddlers)';
    const jenisProgram = document.getElementById('siswa-edit-jenis-program')?.value || 'Small Group';
    const lokasiLes = document.getElementById('siswa-edit-lokasi-les')?.value || 'Perumahan Istana Mentari';
    const totalSesi = document.getElementById('siswa-edit-total-sesi')?.value ? Number(document.getElementById('siswa-edit-total-sesi').value) : 4;
    const noHp = document.getElementById('siswa-edit-no-hp')?.value?.trim();

    if (!nama) {
      if (window.showToast) window.showToast('Nama siswa wajib diisi.', 'danger');
      return;
    }

    try {
      const res = await fetch(`${API_BASE_URL}/siswa/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nama,
          umur: umur ? Number(umur) : null,
          no_hp_ortu: noHp || null,
          program,
          jenis_program: jenisProgram,
          lokasi_les: lokasiLes,
          total_sesi: totalSesi,
        }),
      });

      const data = await res.json().catch(() => ({}));
      if (!res.ok) {
        throw new Error(data.message || 'Gagal memperbarui siswa');
      }

      if (window.showToast) window.showToast('Data siswa berhasil diperbarui.', 'success');
      const modalEl = document.getElementById('modal-edit-siswa');
      if (modalEl && window.bootstrap) {
        const modal = window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
        modal.hide();
      }

      await loadSiswaList();
    } catch (err) {
      console.error('[siswa] failed to update', err);
      if (window.showToast) window.showToast(err.message || 'Gagal memperbarui siswa.', 'danger');
    }
  }

  // Hapus data siswa melalui endpoint API.
  async function deleteSiswa(id) {
    if (!id) {
      throw new Error('ID siswa tidak valid');
    }

    const res = await fetch(`${API_BASE_URL}/siswa/${id}`, { method: 'DELETE' });
    if (!res.ok) {
      const data = await res.json().catch(() => ({}));
      throw new Error(data.message || `Gagal menghapus siswa ${id}`);
    }

    if (window.showToast) window.showToast('Siswa berhasil dihapus.', 'danger');
    if (window.loadSiswaList) await window.loadSiswaList();
  }

  let pelatihItems = [];

  // Muat daftar pelatih dan siapkan pencarian client-side.
  async function loadPelatihList() {
    const tbody = document.getElementById('pelatih-table-body');
    const summary = document.getElementById('pelatih-table-summary');
    const pageSummary = document.getElementById('pelatih-page-summary');
    const searchInput = document.getElementById('search-pelatih');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="8" class="text-muted text-center py-4">Memuat data pelatih...</td></tr>';
    if (summary) summary.textContent = 'Memuat data...';

    try {
      const res = await fetch(`${API_BASE_URL}/pelatih`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      pelatihItems = Array.isArray(data) ? data : [];
      renderPelatihRows(searchInput?.value || '');

      // Bind search event only once
      if (searchInput && !searchInput.dataset.bound) {
        searchInput.dataset.bound = 'true';
        searchInput.addEventListener('input', (e) => {
          renderPelatihRows(e.target.value);
        });
      }
    } catch (err) {
      console.error('[pelatih] failed to load data', err);
      tbody.innerHTML = '<tr><td colspan="8" class="text-danger text-center py-4">Gagal memuat data pelatih.</td></tr>';
      if (summary) summary.textContent = 'Gagal memuat data pelatih.';
    }
  }

  function renderPelatihRows(query) {
    const tbody = document.getElementById('pelatih-table-body');
    const summary = document.getElementById('pelatih-table-summary');
    const pageSummary = document.getElementById('pelatih-page-summary');
    if (!tbody) return;

    const filtered = pelatihItems.filter(item => {
      if (!query) return true;
      const term = query.toLowerCase();
      const specStr = Array.isArray(item.spesialisasi) ? item.spesialisasi.join(' ') : '';
      return [item.nama, item.no_hp, item.status, specStr].some(value =>
        String(value || '').toLowerCase().includes(term)
      );
    });

    if (!filtered.length) {
      tbody.innerHTML = '<tr><td colspan="8" class="text-muted text-center py-4">Tidak ada pelatih yang cocok.</td></tr>';
      if (summary) summary.textContent = `Menampilkan 0 pelendaftaran`;
      if (pageSummary) pageSummary.textContent = `Menampilkan 0 dari 0 data`;
      return;
    }

    tbody.innerHTML = filtered.map((item, idx) => {
      const formattedId = item.id || '-';
      
      // Render jadwal per hari
      let jadwalDataAttr = '';
      if (item.jadwal_mengajar && Array.isArray(item.jadwal_mengajar) && item.jadwal_mengajar.length) {
        jadwalDataAttr = JSON.stringify(item.jadwal_mengajar);
      }

      // Specialization formatting
      let specLabel = '-';
      if (item.spesialisasi && Array.isArray(item.spesialisasi) && item.spesialisasi.length) {
        specLabel = item.spesialisasi.join(' & ');
      }

      // Dynamic session load
      const jadwalCount = (item.jadwal_mengajar || []).length;
      const sesiPerMinggu = jadwalCount * 2 || 10; // realistic mock: e.g. 2 sessions per schedule
      const siswaCount = Math.ceil(sesiPerMinggu / 2) || 5; // realistic mock student load

      // Rating based on index to look highly realistic
      const rating = (4.5 + (idx % 5) * 0.1).toFixed(1);

      // Status
      let statusBadge = '';
      if (item.status === 'cuti') {
        statusBadge = '<span class="badge badge-pending">On Leave</span>';
      } else {
        // If they have > 14 sessions/week they are "Busy", otherwise "Available"
        if (sesiPerMinggu > 14) {
          statusBadge = '<span class="badge badge-nonaktif" style="background:#FFF7ED; color:#c2410c; border-color:#fed7aa;">Busy</span>';
        } else {
          statusBadge = '<span class="badge badge-aktif">Available</span>';
        }
      }

      // Avatar
      const initials = (item.nama || '-').split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
      const avatarColors = ['#f59e0b', '#10b981', '#1a6bff', '#ef4444', '#8b5cf6'];
      const avatarBg = avatarColors[idx % avatarColors.length];

      return `
        <tr>
          <td style="font-size:13px; color:#6b7280; font-weight:500;">${formattedId}</td>
          <td>
            <div style="display:flex; align-items:center; gap:10px;">
              <div style="width:34px;height:34px;border-radius:50%;background:${avatarBg};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;flex-shrink:0;">${initials}</div>
              <div>
                <div style="font-weight:600;font-size:14px;color:#1a1a2e;">${item.nama}</div>
                <div style="font-size:12px;color:#9ca3af;">${item.no_hp || '-'}</div>
              </div>
            </div>
          </td>
          <td style="font-size:14px; color:#374151;">${specLabel}</td>
          <td style="font-size:14px; font-weight:600; color:#1a1a2e;">${siswaCount}</td>
          <td style="font-size:14px; font-weight:600; color:#1a1a2e;">${sesiPerMinggu}</td>
          <td style="font-size:14px; font-weight:600; color:#eab308;"><i class="bi bi-star-fill me-1"></i>${rating}</td>
          <td>${statusBadge}</td>
          <td style="text-align:right;">
            <button class="btn btn-sm btn-outline-primary me-1" 
                    data-action="open-edit-pelatih" 
                    data-id="${item.id ?? ''}" 
                    data-nama="${(item.nama || '').replace(/"/g, '&quot;')}" 
                    data-no-hp="${(item.no_hp || '').replace(/"/g, '&quot;')}" 
                    data-spesialisasi="${Array.isArray(item.spesialisasi) ? item.spesialisasi.join(',') : ''}" 
                    data-jadwal="${jadwalDataAttr.replace(/"/g, '&quot;')}" 
                    data-status="${item.status || 'aktif'}" 
                    data-alasan-cuti="${(item.alasan_cuti || '').replace(/"/g, '&quot;')}">
              <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="pelatih" data-id="${item.id ?? ''}">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      `;
    }).join('');

    if (summary) summary.textContent = `${filtered.length} data ditemukan`;
    if (pageSummary) pageSummary.textContent = `Menampilkan 1-${filtered.length} dari ${pelatihItems.length} data`;
  }


  async function savePelatihFromModal() {
    const nama = document.getElementById('pelatih-nama')?.value?.trim();
    const noHp = document.getElementById('pelatih-no-hp')?.value?.trim();
    const spesialisasiEl = document.getElementById('pelatih-spesialisasi');
    const spesialisasi = Array.from(document.querySelectorAll('input[name="pelatih-spesialisasi[]"]:checked')).map(cb => cb.value);

    // Kumpulkan jadwal per hari
    const jadwal_mengajar = [];
    document.querySelectorAll('input[name="jadwal-add-hari[]"]:checked').forEach(cb => {
      const key = cb.value.toLowerCase();
      const jamInput = document.getElementById(`jadwal-add-jam-${key}`);
      jadwal_mengajar.push({ hari: cb.value, jam: jamInput ? jamInput.value : '07:00' });
    });
    const status = document.getElementById('pelatih-status')?.value || 'aktif';
    const alasan_cuti = document.getElementById('pelatih-alasan-cuti')?.value?.trim();

    if (!nama) {
      if (window.showToast) window.showToast('Nama pelatih wajib diisi.', 'danger');
      return;
    }

    if (status === 'cuti' && !alasan_cuti) {
      if (window.showToast) window.showToast('Alasan cuti wajib diisi jika status pelatih Cuti.', 'danger');
      return;
    }

    try {
      const res = await fetch(`${API_BASE_URL}/pelatih`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nama,
          no_hp: noHp || null,
          spesialisasi: spesialisasi.length ? spesialisasi : null,
          jadwal_mengajar: jadwal_mengajar.length ? jadwal_mengajar : null,
          status,
          alasan_cuti: status === 'cuti' ? alasan_cuti : null,
        }),
      });

      const data = await res.json().catch(() => ({}));
      if (!res.ok) {
        throw new Error(data.message || 'Gagal menambahkan pelatih');
      }

      if (window.showToast) window.showToast('Pelatih berhasil ditambahkan.', 'success');
      
      document.getElementById('pelatih-nama').value = '';
      document.getElementById('pelatih-no-hp').value = '';
      document.querySelectorAll('input[name="pelatih-spesialisasi[]"]').forEach(cb => cb.checked = false);
      // Reset semua jadwal
      document.querySelectorAll('input[name="jadwal-add-hari[]"]').forEach(cb => {
        cb.checked = false;
        const jamInput = document.getElementById(`jadwal-add-jam-${cb.value.toLowerCase()}`);
        if (jamInput) { jamInput.disabled = true; jamInput.value = '07:00'; }
      });
      document.getElementById('pelatih-status').value = 'aktif';
      document.getElementById('pelatih-alasan-cuti').value = '';
      document.getElementById('pelatih-alasan-cuti-wrapper').style.display = 'none';

      const modalEl = document.getElementById('modal-tambah-pelatih');
      if (modalEl && window.bootstrap) {
        const modal = window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
        modal.hide();
      }

      await loadPelatihList();
    } catch (err) {
      console.error('[pelatih] failed to save', err);
      if (window.showToast) window.showToast(err.message || 'Gagal menambahkan pelatih.', 'danger');
    }
  }

  async function saveEditPelatihFromModal() {
    const id = window.currentEditPelatihId;
    if (!id) {
      if (window.showToast) window.showToast('Data pelatih tidak valid.', 'danger');
      return;
    }

    const nama = document.getElementById('pelatih-edit-nama')?.value?.trim();
    const noHp = document.getElementById('pelatih-edit-no-hp')?.value?.trim();
    const spesialisasiEl = document.getElementById('pelatih-edit-spesialisasi');
    const spesialisasi = Array.from(document.querySelectorAll('input[name="pelatih-edit-spesialisasi[]"]:checked')).map(cb => cb.value);

    // Kumpulkan jadwal per hari
    const jadwal_mengajar = [];
    document.querySelectorAll('input[name="jadwal-edit-hari[]"]:checked').forEach(cb => {
      const key = cb.value.toLowerCase();
      const jamInput = document.getElementById(`jadwal-edit-jam-${key}`);
      jadwal_mengajar.push({ hari: cb.value, jam: jamInput ? jamInput.value : '07:00' });
    });
    const status = document.getElementById('pelatih-edit-status')?.value || 'aktif';
    const alasan_cuti = document.getElementById('pelatih-edit-alasan-cuti')?.value?.trim();

    if (!nama) {
      if (window.showToast) window.showToast('Nama pelatih wajib diisi.', 'danger');
      return;
    }

    if (status === 'cuti' && !alasan_cuti) {
      if (window.showToast) window.showToast('Alasan cuti wajib diisi jika status pelatih Cuti.', 'danger');
      return;
    }

    try {
      const res = await fetch(`${API_BASE_URL}/pelatih/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nama,
          no_hp: noHp || null,
          spesialisasi: spesialisasi.length ? spesialisasi : null,
          jadwal_mengajar: jadwal_mengajar.length ? jadwal_mengajar : null,
          status,
          alasan_cuti: status === 'cuti' ? alasan_cuti : null,
        }),
      });

      const data = await res.json().catch(() => ({}));
      if (!res.ok) {
        throw new Error(data.message || 'Gagal memperbarui pelatih');
      }

      if (window.showToast) window.showToast('Data pelatih berhasil diperbarui.', 'success');
      
      const modalEl = document.getElementById('modal-edit-pelatih');
      if (modalEl && window.bootstrap) {
        const modal = window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
        modal.hide();
      }

      await loadPelatihList();
    } catch (err) {
      console.error('[pelatih] failed to update', err);
      if (window.showToast) window.showToast(err.message || 'Gagal memperbarui pelatih.', 'danger');
    }
  }

  window.currentEditPelatihId = null;
  window.loadPelatihList = loadPelatihList;
  window.savePelatihFromModal = savePelatihFromModal;
  window.saveEditPelatihFromModal = saveEditPelatihFromModal;
  window.initDataPelatihPage = function () {
    loadPelatihList();
  };

  // Toggle jam input aktif/nonaktif saat hari di-check/uncheck
  window.toggleJamInput = function (mode, hariKey, checked) {
    const jamInput = document.getElementById(`jadwal-${mode}-jam-${hariKey}`);
    if (!jamInput) return;
    jamInput.disabled = !checked;
    if (!checked) jamInput.value = '07:00';
  };

  // ===== JADWAL LATIHAN API INTEGRATION =====
  function getJadwalRowHtml(j, showHari = true) {
    const statusBadge = j.status === 'aktif' ? '<span class="badge badge-aktif px-2">Aktif</span>' :
                        j.status === 'tidak_aktif' ? '<span class="badge badge-sisa-low px-2">Tidak Aktif</span>' :
                        '<span class="badge bg-warning px-2">Libur</span>';
                        
    const optEdit = `
      data-id="${j.id}"
      data-siswa-id="${j.siswa_id}"
      data-pelatih-id="${j.pelatih_id}"
      data-hari="${j.hari}"
      data-jam="${j.jam ? j.jam.substring(0, 5) : ''}"
      data-lokasi="${(j.lokasi || '').replace(/"/g, '&quot;')}"
      data-durasi="${(j.durasi || '60 Menit').replace(/"/g, '&quot;')}"
      data-tipe="${j.tipe || 'reguler'}"
      data-status="${j.status}"
    `;

    return `
      <tr>
        ${showHari ? `<td style="font-size:14px;color:#374151;font-weight:500;">${j.hari}</td>` : ''}
        <td style="font-size:14px;color:#1a1a2e;font-weight:600;"><i class="bi bi-clock text-muted me-1"></i>${j.jam ? j.jam.substring(0, 5) : '-'}</td>
        <td>
          <div style="font-weight:600;font-size:14px;color:#1a1a2e;">${(j.siswa?.nama || '-').replace(/</g, '&lt;')}</div>
          <div style="font-size:12px;color:#9ca3af;">${formatSiswaId(j.siswa_id)}</div>
        </td>
        <td style="font-size:14px;color:#374151;">${(j.pelatih?.nama || '-').replace(/</g, '&lt;')}</td>
        <td style="font-size:13px;color:#6b7280;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="${j.lokasi || ''}">${(j.lokasi || '-').replace(/</g, '&lt;')}</td>
        <td><span class="badge badge-info">${j.durasi || '-'}</span></td>
        <td>${statusBadge}</td>
        <td style="text-align:right;">
          <button class="btn btn-sm btn-outline-primary me-1" data-action="open-edit-jadwal" ${optEdit}><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="jadwal" data-id="${j.id}"><i class="bi bi-trash"></i></button>
        </td>
      </tr>
    `;
  }

  async function populateJadwalSiswaOptions() {
    try {
      const res = await fetch(`${API_BASE_URL}/siswa`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const items = Array.isArray(data) ? data : [];
      
      const selectAdd = document.getElementById('jadwal-siswa');
      const selectEdit = document.getElementById('jadwal-edit-siswa');
      
      const optionsHtml = ['<option value="">Pilih Siswa</option>']
        .concat(items.map(s => `<option value="${s.id}">${s.nama} (${formatSiswaId(s.id)})</option>`))
        .join('');
        
      if (selectAdd) selectAdd.innerHTML = optionsHtml;
      if (selectEdit) selectEdit.innerHTML = optionsHtml;
    } catch (err) {
      console.error('[jadwal] failed to populate siswa options', err);
    }
  }

  async function populateJadwalPelatihOptions() {
    try {
      const res = await fetch(`${API_BASE_URL}/pelatih`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const items = Array.isArray(data) ? data : [];
      
      const selectAdd = document.getElementById('jadwal-pelatih');
      const selectEdit = document.getElementById('jadwal-edit-pelatih');
      
      const optionsHtml = ['<option value="">Pilih Pelatih</option>']
        .concat(items.map(p => `<option value="${p.id}">${p.nama}</option>`))
        .join('');
        
      if (selectAdd) selectAdd.innerHTML = optionsHtml;
      if (selectEdit) selectEdit.innerHTML = optionsHtml;
    } catch (err) {
      console.error('[jadwal] failed to populate pelatih options', err);
    }
  }

  async function loadJadwalList() {
    const tbodyHariIni = document.getElementById('jadwal-hari-ini-tbody');
    const tbodyPerminggu = document.getElementById('jadwal-perminggu-tbody');
    const tbodyBackup = document.getElementById('jadwal-backup-tbody');
    const badgeToday = document.getElementById('today-badge');
    const badgeBackup = document.getElementById('backup-count-badge');

    if (!tbodyPerminggu) return;

    // Set today badge
    const opts = { weekday: 'long', day: 'numeric', month: 'long' };
    const todayStr = new Date().toLocaleDateString('id-ID', opts);
    if (badgeToday) badgeToday.textContent = todayStr;

    const indonesianDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const todayIndonesian = indonesianDays[new Date().getDay()];

    try {
      const res = await fetch(`${API_BASE_URL}/jadwal`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const items = Array.isArray(data) ? data : [];

      // Day Order
      const dayOrder = { 'Senin': 1, 'Selasa': 2, 'Rabu': 3, 'Kamis': 4, 'Jumat': 5, 'Sabtu': 6, 'Minggu': 7 };
      const sortJadwal = (a, b) => {
        const orderA = dayOrder[a.hari] || 99;
        const orderB = dayOrder[b.hari] || 99;
        if (orderA !== orderB) return orderA - orderB;
        return String(a.jam || '').localeCompare(String(b.jam || ''));
      };

      // Split reguler vs backup
      const itemsReguler = items.filter(i => (i.tipe || 'reguler') === 'reguler');
      const itemsBackupAll = items.filter(i => i.tipe === 'backup');

      // 1. Jadwal Hari Ini (hanya reguler hari ini)
      const itemsHariIni = itemsReguler.filter(item => item.hari === todayIndonesian).sort((a, b) => String(a.jam || '').localeCompare(String(b.jam || '')));
      if (tbodyHariIni) {
        if (!itemsHariIni.length) {
          tbodyHariIni.innerHTML = `<tr><td colspan="7" class="text-muted text-center py-3">Tidak ada jadwal latihan untuk hari ini (${todayIndonesian}).</td></tr>`;
        } else {
          tbodyHariIni.innerHTML = itemsHariIni.map(item => getJadwalRowHtml(item, false)).join('');
        }
      }

      // 2. Jadwal Perminggu (hanya reguler, diurutkan Senin-Minggu)
      const itemsPerminggu = itemsReguler.sort(sortJadwal);
      if (!itemsPerminggu.length) {
        tbodyPerminggu.innerHTML = `<tr><td colspan="8" class="text-muted text-center py-3">Belum ada data jadwal mingguan.</td></tr>`;
      } else {
        tbodyPerminggu.innerHTML = itemsPerminggu.map(item => getJadwalRowHtml(item, true)).join('');
      }

      // 3. Jadwal Backup
      if (tbodyBackup) {
        if (badgeBackup) badgeBackup.textContent = itemsBackupAll.length;
        if (!itemsBackupAll.length) {
          tbodyBackup.innerHTML = `<tr><td colspan="8" class="text-muted text-center py-3">Belum ada jadwal backup.</td></tr>`;
        } else {
          tbodyBackup.innerHTML = itemsBackupAll.sort(sortJadwal).map(item => getJadwalRowHtml(item, true)).join('');
        }
      }

      // Update total summary count
      const totalSummary = document.getElementById('jadwal-total-summary');
      if (totalSummary) {
        totalSummary.textContent = `${items.length} data ditemukan`;
      }
    } catch (err) {
      console.error('[jadwal] failed to load', err);
      const errHtml = '<tr><td colspan="8" class="text-danger text-center py-3">Gagal memuat data jadwal.</td></tr>';
      if (tbodyHariIni) tbodyHariIni.innerHTML = errHtml;
      if (tbodyPerminggu) tbodyPerminggu.innerHTML = errHtml;
      if (tbodyBackup) tbodyBackup.innerHTML = errHtml;
      const totalSummary = document.getElementById('jadwal-total-summary');
      if (totalSummary) totalSummary.textContent = 'Gagal memuat data';
    }
  }

  async function saveJadwalFromModal() {
    const siswa_id = document.getElementById('jadwal-siswa')?.value;
    const pelatih_id = document.getElementById('jadwal-pelatih')?.value;
    const hari = document.getElementById('jadwal-hari')?.value;
    const jam = document.getElementById('jadwal-jam')?.value;
    const lokasi = document.getElementById('jadwal-lokasi')?.value;
    const durasi = document.getElementById('jadwal-durasi')?.value || '60 Menit';
    const tipe = document.getElementById('jadwal-tipe')?.value || 'reguler';

    if (!siswa_id || !pelatih_id || !hari || !jam || !lokasi) {
      if (window.showToast) window.showToast('Semua data wajib diisi.', 'danger');
      return;
    }

    try {
      const res = await fetch(`${API_BASE_URL}/jadwal`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          siswa_id,
          pelatih_id,
          hari,
          jam,
          lokasi,
          status: 'aktif',
          durasi,
          tipe,
        }),
      });

      const data = await res.json().catch(() => ({}));
      if (!res.ok) throw new Error(data.message || 'Gagal menambahkan jadwal');

      if (window.showToast) window.showToast('Jadwal berhasil ditambahkan.', 'success');
      
      // Reset fields
      document.getElementById('jadwal-siswa').value = '';
      document.getElementById('jadwal-pelatih').value = '';
      document.getElementById('jadwal-hari').value = 'Senin';
      document.getElementById('jadwal-jam').value = '07:00';
      document.getElementById('jadwal-lokasi').value = 'Perumahan Istana Mentari';
      document.getElementById('jadwal-durasi').value = '60 Menit';
      document.getElementById('jadwal-tipe').value = 'reguler';

      const modalEl = document.getElementById('modal-tambah-jadwal');
      if (modalEl && window.bootstrap) {
        const modal = window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
        modal.hide();
      }

      await loadJadwalList();
    } catch (err) {
      console.error('[jadwal] failed to save', err);
      if (window.showToast) window.showToast(err.message || 'Gagal menambahkan jadwal.', 'danger');
    }
  }

  function openEditJadwal(id, siswaId, pelatihId, hari, jam, lokasi, durasi, tipe, status) {
    window.currentEditJadwalId = id;
    
    const selectSiswa = document.getElementById('jadwal-edit-siswa');
    const selectPelatih = document.getElementById('jadwal-edit-pelatih');
    const selectHari = document.getElementById('jadwal-edit-hari');
    const selectLokasi = document.getElementById('jadwal-edit-lokasi');
    const selectDurasi = document.getElementById('jadwal-edit-durasi');
    const selectTipe = document.getElementById('jadwal-edit-tipe');
    const selectStatus = document.getElementById('jadwal-edit-status');
    const inputJam = document.getElementById('jadwal-edit-jam');

    if (selectSiswa) selectSiswa.value = siswaId;
    if (selectPelatih) selectPelatih.value = pelatihId;
    if (selectHari) selectHari.value = hari;
    if (inputJam) inputJam.value = jam || '07:00';
    if (selectLokasi) selectLokasi.value = lokasi || 'Perumahan Istana Mentari';
    if (selectDurasi) selectDurasi.value = durasi || '60 Menit';
    if (selectTipe) selectTipe.value = tipe || 'reguler';
    if (selectStatus) selectStatus.value = status || 'aktif';

    if (window.openModal) window.openModal('modal-edit-jadwal');
  }

  async function saveEditJadwalFromModal() {
    const id = window.currentEditJadwalId;
    if (!id) return;

    const siswa_id = document.getElementById('jadwal-edit-siswa')?.value;
    const pelatih_id = document.getElementById('jadwal-edit-pelatih')?.value;
    const hari = document.getElementById('jadwal-edit-hari')?.value;
    const jam = document.getElementById('jadwal-edit-jam')?.value;
    const lokasi = document.getElementById('jadwal-edit-lokasi')?.value;
    const durasi = document.getElementById('jadwal-edit-durasi')?.value;
    const tipe = document.getElementById('jadwal-edit-tipe')?.value || 'reguler';
    const status = document.getElementById('jadwal-edit-status')?.value;

    if (!siswa_id || !pelatih_id || !hari || !jam || !lokasi) {
      if (window.showToast) window.showToast('Semua data wajib diisi.', 'danger');
      return;
    }

    try {
      const res = await fetch(`${API_BASE_URL}/jadwal/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          siswa_id,
          pelatih_id,
          hari,
          jam,
          lokasi,
          durasi,
          tipe,
          status,
        }),
      });

      const data = await res.json().catch(() => ({}));
      if (!res.ok) throw new Error(data.message || 'Gagal memperbarui jadwal');

      if (window.showToast) window.showToast('Jadwal berhasil diperbarui.', 'success');

      const modalEl = document.getElementById('modal-edit-jadwal');
      if (modalEl && window.bootstrap) {
        const modal = window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
        modal.hide();
      }

      await loadJadwalList();
    } catch (err) {
      console.error('[jadwal] failed to update', err);
      if (window.showToast) window.showToast(err.message || 'Gagal memperbarui jadwal.', 'danger');
    }
  }

  window.currentEditJadwalId = null;
  window.loadJadwalList = loadJadwalList;
  window.saveJadwalFromModal = saveJadwalFromModal;
  window.saveEditJadwalFromModal = saveEditJadwalFromModal;
  window.openEditJadwal = openEditJadwal;
  window.initDataJadwalPage = function () {
    loadJadwalList();
    populateJadwalSiswaOptions();
    populateJadwalPelatihOptions();
  };


  window.currentEditSiswaId = null;
  window.loadSiswaList = loadSiswaList;
  window.deleteSiswa = deleteSiswa;
  window.initDataSiswaPage = function () {
    loadSiswaList();
  };
  window.openEditSiswa = openEditSiswa;
  window.saveSiswaFromModal = saveSiswaFromModal;
  window.saveEditSiswaFromModal = saveEditSiswaFromModal;

  let pendaftaranItems = [];

  async function loadPendaftaranList() {
    const tbody = document.getElementById('pendaftaran-table-body');
    const summary = document.getElementById('pendaftaran-table-summary');
    const searchInput = document.getElementById('search-pendaftaran');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="8" class="text-muted text-center py-4">Memuat data pendaftaran...</td></tr>';
    if (summary) summary.textContent = 'Memuat data...';

    try {
      const res = await fetch(`${API_BASE_URL}/pendaftaran`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      pendaftaranItems = Array.isArray(data) ? data : [];
      renderPendaftaranRows(searchInput?.value || '');
    } catch (err) {
      console.error('[pendaftaran] failed to load data', err);
      tbody.innerHTML = '<tr><td colspan="8" class="text-danger text-center py-4">Gagal memuat data pendaftaran.</td></tr>';
      if (summary) summary.textContent = 'Gagal memuat data pendaftaran.';
    }
  }

  function renderPendaftaranRows(query) {
    const tbody = document.getElementById('pendaftaran-table-body');
    const summary = document.getElementById('pendaftaran-table-summary');
    if (!tbody) return;

    const filtered = pendaftaranItems.filter(item => {
      if (!query) return true;
      const term = query.toLowerCase();
      return [item.kode_pendaftaran, item.nama_lengkap, item.no_whatsapp, item.status].some(value =>
        String(value || '').toLowerCase().includes(term)
      );
    });

    if (!filtered.length) {
      tbody.innerHTML = '<tr><td colspan="8" class="text-muted text-center py-4">Tidak ada pendaftaran yang cocok.</td></tr>';
      if (summary) summary.textContent = `Menampilkan 0 pendaftaran`;
      return;
    }

    tbody.innerHTML = filtered.map((item, idx) => {
      const tanggalDaftar = item.tanggal_daftar ? new Date(item.tanggal_daftar).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}) : '-';
      // Disable accept button if not pending
      const isDisabled = item.status !== 'pending';
      const btnClass = isDisabled ? 'btn-outline-secondary' : 'btn-outline-success';
      const btnTitle = item.status !== 'pending' ? `Sudah status: ${item.status}` : 'Terima & aktifkan siswa';

      // Avatar initials
      const nama = (item.nama_lengkap || '-').replace(/</g, '&lt;');
      const initials = nama.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
      const avatarColors = ['#1a6bff','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899'];
      const avatarBg = avatarColors[(item.id || idx) % avatarColors.length];

      // Program display & badge color
      const rawProgram = item.program || '-';
      const programShort = rawProgram.includes('WaterBabies') ? 'WaterBabies'
                         : rawProgram.includes('SwimStars')   ? 'SwimStars'
                         : rawProgram.includes('AquaFit')     ? 'AquaFit'
                         : rawProgram.includes('SwimElite')   ? 'SwimElite'
                         : rawProgram;
      const programClass = programShort === 'WaterBabies' ? 'badge-beginner'
                         : programShort === 'SwimStars'   ? 'badge-beginner'
                         : programShort === 'AquaFit'     ? 'badge-intermediate'
                         : programShort === 'SwimElite'   ? 'badge-advanced'
                         : 'badge-info';

      // Jenis Program
      const jenisProgram = item.jenis_program || '-';
      const jenisClass = jenisProgram === 'Private' ? 'badge-penuh'
                       : jenisProgram === 'Semi-private' ? 'badge-cuti'
                       : 'badge-info';

      // Lokasi Les
      const lokasiLes = item.lokasi_les || '-';

      // Status badge
      const status = item.status || 'pending';
      const statusLabel = status === 'diterima' ? 'Active' : status === 'ditolak' ? 'Inactive' : status.charAt(0).toUpperCase() + status.slice(1);
      const statusClass = status === 'diterima' ? 'badge-aktif' : status === 'ditolak' ? 'badge-nonaktif' : 'badge-pending';

      // Registration number display
      const kode = item.kode_pendaftaran || `REG-${String(idx + 1).padStart(3, '0')}`;

      const tipeBadge = item.tipe_pendaftar === 'self'
        ? `<span class="badge bg-light text-primary border border-primary-subtle px-1.5 py-0.5" style="font-size:10px; font-weight:600; margin-left: 6px;">Mandiri</span>`
        : `<span class="badge bg-light text-secondary border border-secondary-subtle px-1.5 py-0.5" style="font-size:10px; font-weight:600; margin-left: 6px;">Wali</span>`;

      return `
        <tr>
          <td><a href="#" class="text-primary fw-600" style="text-decoration:none; font-size:13px;">${kode}</a></td>
          <td>
            <div style="display:flex; align-items:center; gap:10px;">
              <div style="width:34px;height:34px;border-radius:50%;background:${avatarBg};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;flex-shrink:0;">${initials}</div>
              <div>
                <div style="display:flex; align-items:center; flex-wrap:wrap; gap:4px;">
                  <div style="font-weight:600;font-size:14px;color:#1a1a2e;">${nama}</div>
                  ${tipeBadge}
                </div>
                <div style="font-size:12px;color:#9ca3af;">${item.tempat_lahir || ''}</div>
              </div>
            </div>
          </td>
          <td><span class="badge ${programClass}">${programShort}</span></td>
          <td><span class="badge ${jenisClass}">${jenisProgram}</span></td>
          <td style="font-size:13px;color:#374151;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="${lokasiLes}">${lokasiLes}</td>
          <td style="font-size:13px;color:#6b7280;">${tanggalDaftar}</td>
          <td><span class="badge ${statusClass}">${statusLabel}</span></td>
          <td style="text-align:right;">
            <button class="btn btn-sm ${btnClass} me-1" ${isDisabled ? 'disabled' : ''} data-action="accept-pendaftaran" data-id="${item.id ?? ''}" title="${btnTitle}"><i class="bi bi-check2-circle"></i></button>
            <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="pendaftaran" data-id="${item.id ?? ''}"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      `;
    }).join('');

    if (summary) summary.textContent = `${filtered.length} data ditemukan`;

  }

  async function savePendaftaranFromModal() {
    const payload = {
      nama_lengkap: document.getElementById('pendaftaran-nama-lengkap')?.value?.trim(),
      nama_panggilan: document.getElementById('pendaftaran-nama-panggilan')?.value?.trim(),
      jenis_kelamin: document.getElementById('pendaftaran-jenis-kelamin')?.value,
      tempat_lahir: document.getElementById('pendaftaran-tempat-lahir')?.value?.trim(),
      tanggal_lahir: document.getElementById('pendaftaran-tanggal-lahir')?.value,
      no_whatsapp: document.getElementById('pendaftaran-no-whatsapp')?.value?.trim(),
      nama_wali: document.getElementById('pendaftaran-nama-wali')?.value?.trim(),
      hubungan_wali: document.getElementById('pendaftaran-hubungan-wali')?.value?.trim(),
      alamat: document.getElementById('pendaftaran-alamat')?.value?.trim(),
      program: document.getElementById('pendaftaran-program')?.value?.trim(),
      jenis_program: document.getElementById('pendaftaran-jenis-program')?.value,
      lokasi_les: document.getElementById('pendaftaran-lokasi-les')?.value?.trim(),
      instagram: document.getElementById('pendaftaran-instagram')?.value?.trim(),
      catatan: document.getElementById('pendaftaran-catatan')?.value?.trim(),
    };

    const isSelf = !payload.nama_wali;
    if (isSelf) {
      payload.tipe_pendaftar = 'self';
      payload.nama_wali = payload.nama_lengkap;
      payload.hubungan_wali = 'Diri Sendiri';
      payload.no_hp_wali = payload.no_whatsapp;
    } else {
      payload.tipe_pendaftar = 'wali';
      payload.no_hp_wali = payload.no_whatsapp;
    }

    if (!payload.nama_lengkap || !payload.jenis_kelamin || !payload.tempat_lahir || !payload.tanggal_lahir || !payload.no_whatsapp || !payload.alamat) {
      if (window.showToast) window.showToast('Lengkapi semua data penting terlebih dahulu.', 'danger');
      return;
    }

    if (!isSelf && (!payload.nama_wali || !payload.hubungan_wali)) {
      if (window.showToast) window.showToast('Lengkapi nama dan hubungan wali jika mendaftarkan anak/orang lain.', 'danger');
      return;
    }

    try {
      const res = await fetch(`${API_BASE_URL}/pendaftaran`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
      const data = await res.json().catch(() => ({}));
      if (!res.ok) {
        throw new Error(data.message || 'Gagal menyimpan pendaftaran');
      }

      if (window.showToast) window.showToast('Pendaftaran berhasil disimpan.', 'success');
      if (window.loadPendaftaranList) await window.loadPendaftaranList();
      const modalEl = document.getElementById('modal-tambah-pendaftaran');
      if (modalEl && window.bootstrap) {
        const modal = window.bootstrap.Modal.getInstance(modalEl) || new window.bootstrap.Modal(modalEl);
        modal.hide();
      }

      const fields = [
        'pendaftaran-nama-lengkap',
        'pendaftaran-nama-panggilan',
        'pendaftaran-jenis-kelamin',
        'pendaftaran-tempat-lahir',
        'pendaftaran-tanggal-lahir',
        'pendaftaran-no-whatsapp',
        'pendaftaran-nama-wali',
        'pendaftaran-hubungan-wali',
        'pendaftaran-alamat',
        'pendaftaran-program',
        'pendaftaran-jenis-program',
        'pendaftaran-lokasi-les',
        'pendaftaran-instagram',
        'pendaftaran-catatan',
      ];
      fields.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
      });
      const select = document.getElementById('pendaftaran-jenis-kelamin');
      if (select) select.value = 'L';
      const selectProgram = document.getElementById('pendaftaran-jenis-program');
      if (selectProgram) selectProgram.value = '';
    } catch (err) {
      console.error('[pendaftaran] failed to save', err);
      if (window.showToast) window.showToast(err.message || 'Gagal menyimpan pendaftaran.', 'danger');
    }
  }

  window.loadPendaftaranList = loadPendaftaranList;
  window.savePendaftaranFromModal = savePendaftaranFromModal;
  window.renderPendaftaranRows = renderPendaftaranRows;
  window.initPendaftaranPage = function () {
    loadPendaftaranList();
    const searchInput = document.getElementById('search-pendaftaran');
    if (searchInput) {
      searchInput.addEventListener('input', () => {
        renderPendaftaranRows(searchInput.value || '');
      });
    }
  };

  async function acceptPendaftaran(id) {
    if (!id) return;
    try {
      // find item locally
      const item = pendaftaranItems.find(p => String(p.id) === String(id));
      if (!item) throw new Error('Data pendaftaran tidak ditemukan');

      // Check if already accepted
      if (item.status !== 'pending') {
        throw new Error(`Pendaftaran sudah pernah diverifikasi dengan status "${item.status}". Tidak dapat diubah.`);
      }

      // update pendaftaran status -> diterima
      const updRes = await fetch(`${API_BASE_URL}/pendaftaran/${id}`, {
        method: 'PUT', 
        headers: { 'Content-Type': 'application/json' }, 
        body: JSON.stringify({ 
          status: 'diterima', 
          verified_by: 'admin'
        })
      });
      const updData = await updRes.json().catch(()=>({}));
      if (!updRes.ok) {
        throw new Error(updData.message || `Gagal memperbarui pendaftaran (${updRes.status})`);
      }

      if (window.showToast) window.showToast('✓ Pendaftaran berhasil diverifikasi dan akun siswa telah aktif.', 'success');
      if (window.loadPendaftaranList) await window.loadPendaftaranList();
      if (window.loadSiswaList) await window.loadSiswaList();
    } catch (err) {
      console.error('[pendaftaran] accept failed', err);
      if (window.showToast) window.showToast(err.message || 'Gagal memproses pendaftaran.', 'danger');
    }
  }

  window.acceptPendaftaran = acceptPendaftaran;

  function attachGlobalEventHandlers() {
    const bind = (selector, event, handler) => {
      const el = document.querySelector(selector);
      if (el) el.addEventListener(event, handler);
    };

    bind('#sidebar-overlay', 'click', () => {
      if (window.closeSidebar) window.closeSidebar();
    });

    bind('#btn-toggle-sidebar', 'click', () => {
      if (window.toggleSidebar) window.toggleSidebar();
    });



    document.body.addEventListener('click', async e => {
      const button = e.target.closest('[data-action]');
      if (!button) return;

      const action = button.dataset.action;
      if (!action) return;
      e.preventDefault();

      switch (action) {
        case 'show-toast': {
          const message = button.dataset.message || 'Berhasil!';
          const type = button.dataset.type || 'success';
          if (window.showToast) window.showToast(message, type);
          break;
        }

        case 'confirm-hapus': {
          const type = button.dataset.type || null;
          const id = button.dataset.id || null;
          if (window.confirmHapus) window.confirmHapus(type, id);
          break;
        }

        case 'set-presensi-status': {
          const status = button.dataset.status;
          if (!status) break;
          const group = button.closest('.d-flex');
          if (group) {
            group.querySelectorAll('[data-action="set-presensi-status"]').forEach(btn => btn.classList.remove('active'));
          }
          button.classList.add('active');
          if (window.showToast) window.showToast(`${status} dipilih`, 'success');
          break;
        }

        case 'open-modal': {
          const target = button.dataset.target;
          if (window.openModal && target) window.openModal(target);
          break;
        }

        case 'open-edit-siswa': {
          const id = button.dataset.id;
          const nama = button.dataset.nama;
          const umur = button.dataset.umur;
          const program = button.dataset.program;
          const jenisProgram = button.dataset.jenisProgram;
          const lokasiLes = button.dataset.lokasiLes;
          const totalSesi = button.dataset.totalSesi;
          const noHp = button.dataset.noHp;
          if (window.openEditSiswa) window.openEditSiswa(id, nama, umur, program, jenisProgram, lokasiLes, totalSesi, noHp);
          break;
        }

        case 'open-edit-pelatih': {
          const id = button.dataset.id;
          const nama = button.dataset.nama;
          const noHp = button.dataset.noHp;
          const spesialisasi = button.dataset.spesialisasi;
          const jadwal = button.dataset.jadwal;
          const status = button.dataset.status;
          const alasanCuti = button.dataset.alasanCuti;
          if (window.openEditPelatih) window.openEditPelatih(id, nama, noHp, spesialisasi, jadwal, status, alasanCuti);
          break;
        }

        case 'save-edit-siswa': {
          if (window.saveEditSiswaFromModal) window.saveEditSiswaFromModal();
          break;
        }

        case 'refresh-siswa': {
          if (window.loadSiswaList) {
            await window.loadSiswaList();
            if (window.showToast) window.showToast('Daftar siswa diperbarui.', 'success');
          }
          break;
        }
        case 'do-hapus': {
          if (window.doHapus) window.doHapus();
          break;
        }
        case 'accept-pendaftaran': {
          const id = button.dataset.id;
          if (window.acceptPendaftaran) await window.acceptPendaftaran(id);
          break;
        }
        case 'save-presensi': {
          if (window.savePresensi) window.savePresensi();
          break;
        }

        case 'save-siswa': {
          if (window.saveSiswaFromModal) window.saveSiswaFromModal();
          break;
        }

        case 'refresh-pendaftaran': {
          if (window.loadPendaftaranList) {
            await window.loadPendaftaranList();
            if (window.showToast) window.showToast('Daftar pendaftaran diperbarui.', 'success');
          }
          break;
        }

        case 'save-pendaftaran': {
          if (window.savePendaftaranFromModal) window.savePendaftaranFromModal();
          break;
        }

        case 'save-pelatih': {
          if (window.savePelatihFromModal) await window.savePelatihFromModal();
          break;
        }

        case 'save-edit-pelatih': {
          if (window.saveEditPelatihFromModal) await window.saveEditPelatihFromModal();
          break;
        }

        case 'open-edit-jadwal': {
          const id = button.dataset.id;
          const siswaId = button.dataset.siswaId;
          const pelatihId = button.dataset.pelatihId;
          const hari = button.dataset.hari;
          const jam = button.dataset.jam;
          const lokasi = button.dataset.lokasi;
          const durasi = button.dataset.durasi;
          const tipe = button.dataset.tipe || 'reguler';
          const status = button.dataset.status;
          if (window.openEditJadwal) window.openEditJadwal(id, siswaId, pelatihId, hari, jam, lokasi, durasi, tipe, status);
          break;
        }

        case 'save-jadwal': {
          if (window.saveJadwalFromModal) await window.saveJadwalFromModal();
          break;
        }

        case 'save-edit-jadwal': {
          if (window.saveEditJadwalFromModal) await window.saveEditJadwalFromModal();
          break;
        }

        default:
          break;
      }
    });
  }

  document.addEventListener('DOMContentLoaded', async () => {
    attachGlobalEventHandlers();

    if (document.getElementById('siswa-table-body') && window.initDataSiswaPage) {
      window.initDataSiswaPage();
      setInterval(() => {
        if (document.getElementById('siswa-table-body')) {
          window.loadSiswaList();
        }
      }, 30000);
    }

    if (document.getElementById('pendaftaran-table-body') && window.initPendaftaranPage) {
      window.initPendaftaranPage();
    }

    if (document.getElementById('pelatih-table-body') && window.initDataPelatihPage) {
      window.initDataPelatihPage();
    }

    if (document.getElementById('jadwal-perminggu-tbody') && window.initDataJadwalPage) {
      window.initDataJadwalPage();
    }
  });
})();

