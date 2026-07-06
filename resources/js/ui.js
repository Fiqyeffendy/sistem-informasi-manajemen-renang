// ═══════════════════════════════════
//  UI Utilities – Toast & Modals
// ═══════════════════════════════════

(function () {
  /**
   * Show a Bootstrap toast notification.
   * @param {string} msg   – message text
   * @param {'success'|'danger'} type
   */
  function showToast(msg, type = 'success') {
    const toast = document.getElementById('toast-msg');
    const text = document.getElementById('toast-text');

    if (!toast || !text) return;

    text.textContent = msg;
    toast.className = `toast align-items-center text-white border-0 bg-${type === 'danger' ? 'danger' : 'success'}`;

    if (window.bootstrap?.Toast) {
      window.bootstrap.Toast.getOrCreateInstance(toast, { delay: 2500 }).show();
    }
  }

  /**
   * Open any Bootstrap modal by id.
   * @param {string} id – the modal element id
   */
  function openModal(id) {
    const modalEl = document.getElementById(id);
    if (!modalEl || !window.bootstrap?.Modal) return;
    new window.bootstrap.Modal(modalEl).show();
  }

  // ===== Delete flow (demo-ready) =====
  // Catatan: Karena saat ini tidak ada backend/API, kita simpan state delete
  // dan saat tombol "Hapus" ditekan, minimal tampilkan toast + tutup modal.
  // Hook ini siap di-extend ke fetch/delete API.
  let _hapusState = { type: null, id: null };

  /**
   * Show the generic delete-confirmation modal.
   * @param {string} type – entity type (siswa/pelatih/jadwal/dll)
   * @param {string|number|null} id – optional entity id
   */
  function confirmHapus(type, id = null) {
    _hapusState = { type: type ?? null, id: id ?? null };

    const modalEl = document.getElementById('modal-hapus');
    if (modalEl) {
      const msg = modalEl.querySelector('[data-hapus-message]');
      if (msg) {
        const t = _hapusState.type ? String(_hapusState.type) : 'data';
        msg.textContent = `Yakin ingin menghapus ${t}? Tindakan ini tidak dapat dibatalkan.`;
      }
    }

    openModal('modal-hapus');
  }

  function doHapus() {
    const { type, id } = _hapusState;
    const label = type ? String(type) : 'Data';

    if (type === 'siswa' && id && window.deleteSiswa) {
      window.deleteSiswa(id)
        .catch(err => {
          console.error('[siswa] delete failed', err);
          showToast(err.message || 'Gagal menghapus siswa.', 'danger');
        })
        .finally(() => {
          _hapusState = { type: null, id: null };
        });
      return;
    }

    if (type === 'pendaftaran' && id) {
      // call API to delete pendaftaran
      fetch(`/api/pendaftaran/${id}`, { method: 'DELETE' })
        .then(async res => {
          const data = await res.json().catch(()=>({}));
          if (!res.ok) throw new Error(data.message || `Gagal menghapus pendaftaran (${res.status})`);
          showToast('Pendaftaran berhasil dihapus.', 'danger');
          if (window.loadPendaftaranList) window.loadPendaftaranList();
        })
        .catch(err => {
          console.error('[pendaftaran] delete failed', err);
          showToast(err.message || 'Gagal menghapus pendaftaran.', 'danger');
        })
        .finally(() => { _hapusState = { type: null, id: null }; });
      return;
    }

    if (type === 'pelatih' && id) {
      fetch(`/api/pelatih/${id}`, { method: 'DELETE' })
        .then(async res => {
          const data = await res.json().catch(()=>({}));
          if (!res.ok) throw new Error(data.message || `Gagal menghapus pelatih (${res.status})`);
          showToast('Pelatih berhasil dihapus.', 'danger');
          if (window.loadPelatihList) window.loadPelatihList();
        })
        .catch(err => {
          console.error('[pelatih] delete failed', err);
          showToast(err.message || 'Gagal menghapus pelatih.', 'danger');
        })
        .finally(() => { _hapusState = { type: null, id: null }; });
      return;
    }

    if (type === 'jadwal' && id) {
      fetch(`/api/jadwal/${id}`, { method: 'DELETE' })
        .then(async res => {
          const data = await res.json().catch(()=>({}));
          if (!res.ok) throw new Error(data.message || `Gagal menghapus jadwal (${res.status})`);
          showToast('Jadwal berhasil dihapus.', 'danger');
          if (window.loadJadwalList) window.loadJadwalList();
        })
        .catch(err => {
          console.error('[jadwal] delete failed', err);
          showToast(err.message || 'Gagal menghapus jadwal.', 'danger');
        })
        .finally(() => { _hapusState = { type: null, id: null }; });
      return;
    }

    showToast(`${label} berhasil dihapus!`, 'danger');
    _hapusState = { type: null, id: null };
  }

  // ===== Demo integration: simpan presensi dari form pelatih =====
  // Dipakai oleh button “Simpan Presensi” di tab #input-presensi.
  function savePresensi() {
    const siswaSel = document.getElementById('input-presensi-siswa');
    const jadwalSel = document.getElementById('input-presensi-jadwal');
    const selectedStatus = document.querySelector('[data-action="set-presensi-status"].active')?.dataset.status || 'Hadir';

    const targetBodies = [
      document.getElementById('input-presensi-tbody'),
      document.getElementById('presensi-tbody'),
    ].filter(Boolean);

    if (!targetBodies.length) {
      showToast('Tabel presensi tidak ditemukan', 'danger');
      return;
    }

    const nama = siswaSel?.selectedOptions?.[0]?.textContent?.trim() || 'Siswa';
    const jadwal = jadwalSel?.selectedOptions?.[0]?.textContent?.trim() || 'Jadwal';
    const jam = jadwal.includes('06:00') ? '06:00' : jadwal.includes('15:00') ? '15:00' : '—';
    const badgeClass = selectedStatus === 'Izin' ? 'badge-izin' : selectedStatus === 'Alpha' ? 'badge-alpha' : 'badge-hadir';
    const statusBadge = `<span class="badge ${badgeClass} px-2">${selectedStatus}</span>`;

    targetBodies.forEach(tbody => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><strong>${nama}</strong></td>
        <td>${jam}</td>
        <td>${statusBadge}</td>
        <td>${jadwal}</td>
        <td>
          <button class="btn btn-sm btn-outline-primary me-1" data-action="show-toast" data-message="Presensi diperbarui!"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-outline-danger" data-action="confirm-hapus" data-type="presensi"><i class="bi bi-trash"></i></button>
        </td>
      `;
      tbody.prepend(tr);
    });

    showToast('Presensi tersimpan! (demo)', 'success');
  }

  function toggleAlasanCuti(type) {
    const statusEl = document.getElementById(type === 'add' ? 'pelatih-status' : 'pelatih-edit-status');
    const wrapperEl = document.getElementById(type === 'add' ? 'pelatih-alasan-cuti-wrapper' : 'pelatih-edit-alasan-cuti-wrapper');
    if (!statusEl || !wrapperEl) return;

    if (statusEl.value === 'cuti') {
      wrapperEl.style.display = 'block';
    } else {
      wrapperEl.style.display = 'none';
      const textarea = wrapperEl.querySelector('textarea');
      if (textarea) textarea.value = '';
    }
  }

  window.toggleAlasanCuti = toggleAlasanCuti;
  window.savePresensi = savePresensi;

  window.showToast = showToast;
  window.openModal = openModal;
  window.confirmHapus = confirmHapus;
  window.doHapus = doHapus;
})();

