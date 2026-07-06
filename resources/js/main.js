// ═══════════════════════════════════
//  main.js – App Entry Point
//  Menginisialisasi aplikasi dan mengikat event handler global.
//  Semua interaksi UI sekarang menggunakan data-action delegation.
// ═══════════════════════════════════

(function () {
  function initDynamicSections() {
    const map = {
      // Admin
      'dashboard-admin': document.getElementById('root-dashboard-admin'),
      'data-siswa': document.getElementById('root-data-siswa'),
      'data-pelatih': document.getElementById('root-data-pelatih'),
      'jadwal': document.getElementById('root-jadwal'),
      'presensi': document.getElementById('root-presensi'),
      'sesi': document.getElementById('root-sesi'),
      'laporan': document.getElementById('root-laporan'),

      // Pelatih
      'dashboard-pelatih': document.getElementById('root-dashboard-pelatih'),
      'jadwal-pelatih': document.getElementById('root-jadwal-pelatih'),
      'siswa-pelatih': document.getElementById('root-siswa-pelatih'),
      'input-presensi': document.getElementById('root-input-presensi'),

      // Siswa
      'dashboard-siswa': document.getElementById('root-dashboard-siswa'),
      'jadwal-siswa': document.getElementById('root-jadwal-siswa'),
      'riwayat-presensi': document.getElementById('root-riwayat-presensi'),
      'sesi-siswa': document.getElementById('root-sesi-siswa'),
    };

    Object.keys(map).forEach(sectionId => {
      const rootEl = map[sectionId];
      const sectionEl = document.getElementById(sectionId);
      if (!rootEl || !sectionEl) return;

      // jangan ada markup lama yang tersisa untuk section ini
      // (index.html sebelumnya sempat kebablasan ada markup lama yang bikin layout berantakan)
      sectionEl.querySelectorAll(':scope > :not(#' + rootEl.id + ')').forEach(el => el.remove());

      // konten dipastikan kosong sebelum di-load partial
      rootEl.innerHTML = '';
      sectionEl.dataset.partialLoaded = 'false';
    });
  }


  const API_BASE_URL = '/api';

  function formatSiswaId(id) {
    if (id == null || id === '') return '-';
    const number = Number(id);
    if (Number.isNaN(number)) return String(id);
    return `S${String(number).padStart(3, '0')}`;
  }

  async function loadSiswaList() {
    const tbody = document.getElementById('siswa-table-body');
    const summary = document.getElementById('siswa-table-summary');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="7" class="text-muted">Memuat data siswa...</td></tr>';
    if (summary) summary.textContent = 'Memuat data...';

    try {
      const res = await fetch(`${API_BASE_URL}/siswa`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const items = Array.isArray(data) ? data : [];

      if (!items.length) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-muted">Belum ada data siswa.</td></tr>';
        if (summary) summary.textContent = 'Belum ada data siswa.';
        return;
      }

      tbody.innerHTML = items.map((item, idx) => {
        const totalSesi = Number(item.total_sesi ?? 4);
        const sesiTerpakai = Number(item.sesi_terpakai ?? 0);
        const sisaSesi = Math.max(totalSesi - sesiTerpakai, 0);
        const badgeClass = sisaSesi <= 2 ? 'badge-sisa-low' : sisaSesi <= 5 ? 'badge-sisa-warn' : 'badge-sisa-ok';
        
        // Extract short program nametara
        const programFull = item.program || 'Fella WaterBabies (Swimming Lessons for Toddlers)';
        const programShort = programFull.includes('WaterBabies') ? 'WaterBabies' : 
                            programFull.includes('SwimStars') ? 'SwimStars' :
                            programFull.includes('AquaFit') ? 'AquaFit' : 'SwimElite';
        
        return `
          <tr>
            <td>${idx + 1}</td>
            <td>${formatSiswaId(item.id)}</td>
            <td><strong>${(item.nama || '-').replace(/</g, '&lt;')}</strong></td>
            <td>${item.umur ?? '-'}</td>
            <td><span class="badge badge-info px-2">${programShort}</span></td>
            <td><span class="badge badge-success px-2">${item.jenis_program || 'Small Group'}</span></td>            <td><small>${(item.lokasi_les || 'Perumahan Istana Mentari').substring(0, 18)}...</small></td>            <td>${totalSesi}</td>
            <td><span class="badge ${badgeClass} px-2">${sisaSesi}</span></td>
            <td>
              <button class=\"btn btn-sm btn-outline-primary me-1\" data-action=\"open-edit-siswa\" data-id=\"${item.id ?? ''}\" data-nama=\"${(item.nama || '').replace(/\"/g, '&quot;')}\" data-umur=\"${item.umur ?? ''}\" data-program=\"${programFull.replace(/\"/g, '&quot;')}\" data-jenis-program=\"${item.jenis_program || 'Small Group'}\" data-lokasi-les=\"${(item.lokasi_les || 'Perumahan Istana Mentari').replace(/\"/g, '&quot;')}\" data-total-sesi=\"${totalSesi}\" data-no-hp=\"${item.no_hp_ortu ?? ''}\"><i class=\"bi bi-pencil\"></i></button>
              <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="siswa" data-id="${item.id ?? ''}"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
        `;
      }).join('');

      if (summary) summary.textContent = `Menampilkan ${items.length} siswa`;
    } catch (err) {
      console.error('[siswa] failed to load data', err);
      tbody.innerHTML = '<tr><td colspan="10" class="text-danger">Gagal memuat data siswa.</td></tr>';
      if (summary) summary.textContent = 'Gagal memuat data siswa.';
    }
  }

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

  async function loadPelatihList() {
    const tbody = document.getElementById('pelatih-table-body');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="8" class="text-muted">Memuat data pelatih...</td></tr>';

    try {
      const res = await fetch(`${API_BASE_URL}/pelatih`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const items = Array.isArray(data) ? data : [];

      if (!items.length) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-muted">Belum ada data pelatih.</td></tr>';
        return;
      }

      tbody.innerHTML = items.map((item) => {
        const formattedId = `#P${String(item.id).padStart(2, '0')}`;
        
        // Render jadwal per hari
        let jadwalMengajar = '-';
        let jadwalDataAttr = '';
        if (item.jadwal_mengajar && Array.isArray(item.jadwal_mengajar) && item.jadwal_mengajar.length) {
          jadwalMengajar = item.jadwal_mengajar
            .map(j => `${j.hari} ${j.jam ? j.jam.substring(0, 5) : ''}`)
            .join(', ');
          jadwalDataAttr = JSON.stringify(item.jadwal_mengajar);
        }
        
        let statusBadge = '';
        if (item.status === 'cuti') {
          statusBadge = '<span class="badge" style="background-color: var(--warning, #f59e0b); color: #fff;">Cuti</span>';
        } else {
          statusBadge = '<span class="badge badge-aktif px-2">Aktif</span>';
        }
        
        const alasanCuti = item.alasan_cuti || '-';

        return `
          <tr>
            <td>${formattedId}</td>
            <td><strong>${(item.nama || '-').replace(/</g, '&lt;')}</strong></td>
            <td>${item.no_hp || '-'}</td>
            <td>${Array.isArray(item.spesialisasi) && item.spesialisasi.length ? item.spesialisasi.join(', ') : '-'}</td>
            <td>${jadwalMengajar}</td>
            <td>${statusBadge}</td>
            <td><small class="text-muted">${alasanCuti.replace(/</g, '&lt;')}</small></td>
            <td>
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
    } catch (err) {
      console.error('[pelatih] failed to load data', err);
      tbody.innerHTML = '<tr><td colspan="8" class="text-danger">Gagal memuat data pelatih.</td></tr>';
    }
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
        ${showHari ? `<td>${j.hari}</td>` : ''}
        <td>${j.jam ? j.jam.substring(0, 5) : '-'}</td>
        <td><strong>${(j.siswa?.nama || '-').replace(/</g, '&lt;')}</strong></td>
        <td>${(j.pelatih?.nama || '-').replace(/</g, '&lt;')}</td>
        <td><small>${(j.lokasi || '-').replace(/</g, '&lt;')}</small></td>
        <td>${j.durasi || '-'}</td>
        <td>${statusBadge}</td>
        <td>
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
    } catch (err) {
      console.error('[jadwal] failed to load', err);
      const errHtml = '<tr><td colspan="8" class="text-danger text-center py-3">Gagal memuat data jadwal.</td></tr>';
      if (tbodyHariIni) tbodyHariIni.innerHTML = errHtml;
      if (tbodyPerminggu) tbodyPerminggu.innerHTML = errHtml;
      if (tbodyBackup) tbodyBackup.innerHTML = errHtml;
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
          siswa_id: Number(siswa_id),
          pelatih_id: Number(pelatih_id),
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
          siswa_id: Number(siswa_id),
          pelatih_id: Number(pelatih_id),
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

    tbody.innerHTML = '<tr><td colspan="7" class="text-muted">Memuat data pendaftaran...</td></tr>';
    if (summary) summary.textContent = 'Memuat data...';

    try {
      const res = await fetch(`${API_BASE_URL}/pendaftaran`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      pendaftaranItems = Array.isArray(data) ? data : [];
      renderPendaftaranRows(searchInput?.value || '');
    } catch (err) {
      console.error('[pendaftaran] failed to load data', err);
      tbody.innerHTML = '<tr><td colspan="7" class="text-danger">Gagal memuat data pendaftaran.</td></tr>';
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
      tbody.innerHTML = '<tr><td colspan="7" class="text-muted">Tidak ada pendaftaran yang cocok.</td></tr>';
      if (summary) summary.textContent = `Menampilkan 0 pendaftaran`;
      return;
    }

    tbody.innerHTML = filtered.map((item, idx) => {
      const tanggalDaftar = item.tanggal_daftar ? new Date(item.tanggal_daftar).toLocaleDateString('id-ID') : '-';
      // Disable accept button if not pending or if siswa_id already exists
      const isDisabled = item.status !== 'pending' || item.siswa_id;
      const btnClass = isDisabled ? 'btn-outline-secondary' : 'btn-outline-success';
      const btnTitle = item.siswa_id ? 'Sudah dibuat ke data siswa' : (item.status !== 'pending' ? `Sudah status: ${item.status}` : 'Terima & buat siswa');
      return `
        <tr>
          <td>${idx + 1}</td>
          <td>${item.kode_pendaftaran || '-'}</td>
          <td><strong>${(item.nama_lengkap || '-').replace(/</g, '&lt;')}</strong></td>
          <td>${item.no_whatsapp || '-'}</td>
          <td><span class="badge badge-aktif px-2">${item.status || 'pending'}</span></td>
          <td>${tanggalDaftar}</td>
          <td>
            <button class="btn btn-sm ${btnClass} me-1" ${isDisabled ? 'disabled' : ''} data-action="accept-pendaftaran" data-id="${item.id ?? ''}" title="${btnTitle}"><i class="bi bi-check2-circle"></i></button>
            <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="pendaftaran" data-id="${item.id ?? ''}"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      `;
    }).join('');

    if (summary) summary.textContent = `Menampilkan ${filtered.length} dari ${pendaftaranItems.length} pendaftaran`;
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

    if (!payload.nama_lengkap || !payload.jenis_kelamin || !payload.tempat_lahir || !payload.tanggal_lahir || !payload.no_whatsapp || !payload.nama_wali || !payload.hubungan_wali || !payload.alamat) {
      if (window.showToast) window.showToast('Lengkapi semua data penting terlebih dahulu.', 'danger');
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

      if (item.siswa_id) {
        throw new Error(`Pendaftaran ini sudah dibuat ke data siswa (ID: ${item.siswa_id}). Tidak dapat diverifikasi lagi.`);
      }

      // Calculate age from tanggal_lahir
      const calculateAge = (birthDate) => {
        if (!birthDate) return null;
        const today = new Date();
        const birth = new Date(birthDate);
        let age = today.getFullYear() - birth.getFullYear();
        const monthDiff = today.getMonth() - birth.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
          age--;
        }
        return age > 0 ? age : null;
      };

      // 1) create siswa from pendaftaran data first
      // total_sesi default dari backend seharusnya 4.
      // Jangan hardcode 12/4 di client agar konsisten.
      const siswaPayload = {
        nama: item.nama_lengkap,
        umur: calculateAge(item.tanggal_lahir),
        no_hp_ortu: item.no_whatsapp || null,
        program: item.program || 'Fella WaterBabies (Swimming Lessons for Toddlers)',
        jenis_program: item.jenis_program || 'Small Group',
        lokasi_les: item.lokasi_les || 'Perumahan Istana Mentari',
        sesi_terpakai: 0
      };

      const createRes = await fetch(`${API_BASE_URL}/siswa`, {
        method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(siswaPayload)
      });
      const createData = await createRes.json().catch(()=>({}));
      if (!createRes.ok) {
        throw new Error(createData.message || `Gagal membuat siswa (${createRes.status})`);
      }

      const siswaId = createData.id || createData?.data?.id;
      if (!siswaId) throw new Error('ID siswa tidak ditemukan dalam response');

      // 2) update pendaftaran status -> diterima WITH siswa_id
      const updRes = await fetch(`${API_BASE_URL}/pendaftaran/${id}`, {
        method: 'PUT', 
        headers: { 'Content-Type': 'application/json' }, 
        body: JSON.stringify({ 
          status: 'diterima', 
          verified_by: 'admin',
          siswa_id: siswaId
        })
      });
      const updData = await updRes.json().catch(()=>({}));
      if (!updRes.ok) {
        throw new Error(updData.message || `Gagal memperbarui pendaftaran (${updRes.status})`);
      }

      if (window.showToast) window.showToast('✓ Pendaftaran diterima dan siswa berhasil dibuat.', 'success');
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

    bind('#btn-toggle-pass', 'click', e => {
      e.preventDefault();
      if (window.togglePass) window.togglePass();
    });

    bind('#btn-login', 'click', e => {
      e.preventDefault();
      if (window.doLogin) window.doLogin();
    });

    bind('#sidebar-overlay', 'click', () => {
      if (window.closeSidebar) window.closeSidebar();
    });

    bind('#btn-logout', 'click', () => {
      if (window.doLogout) window.doLogout();
    });

    bind('#btn-toggle-sidebar', 'click', () => {
      if (window.toggleSidebar) window.toggleSidebar();
    });

    ['nav-admin', 'nav-pelatih', 'nav-siswa'].forEach(navId => {
      const navEl = document.getElementById(navId);
      if (!navEl) return;

      navEl.addEventListener('click', e => {
        const link = e.target.closest('.nav-link');
        if (!link || !navEl.contains(link)) return;
        const sectionId = link.dataset.section;
        if (!sectionId) return;
        e.preventDefault();
        if (window.showSection) window.showSection(sectionId, navId);
      });
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
    const sections = document.querySelectorAll('.section');
    sections.forEach(s => {
      s.style.display = 'none';
    });

    const role = localStorage.getItem('simpel-fella-user-role') || 'siswa';
    const roleNavMap = { admin: 'nav-admin', pelatih: 'nav-pelatih', siswa: 'nav-siswa' };
    const navToShow = roleNavMap[role] || 'nav-siswa';
    ['nav-admin', 'nav-pelatih', 'nav-siswa'].forEach(id => {
      const nav = document.getElementById(id);
      if (nav) nav.style.display = (id === navToShow ? 'block' : 'none');
    });

    initDynamicSections();
    attachGlobalEventHandlers();

    const firstSection = document.querySelector('.section');
    if (firstSection) {
      firstSection.style.display = '';
      firstSection.classList.add('fade-in');

      const titleEl = document.getElementById('topbar-title');
      if (titleEl && window.SECTION_TITLES?.[firstSection.id]) {
        titleEl.textContent = window.SECTION_TITLES[firstSection.id];
      }
    }

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

