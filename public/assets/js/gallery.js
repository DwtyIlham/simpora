/**
 * Kartu dokumen atlet.
 * Struktur & class dipertahankan agar handler lama (validate-file,
 * invalidate-file, notes-file, view-img, view-pdf) tetap berjalan.
 */
function escapeHtml(value) {
  return String(value == null ? "" : value).replace(/[&<>"']/g, function (char) {
    return {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;",
    }[char];
  });
}

function templateFile(label, fileUrl, status, type, atletId, role = "admin") {
  const safeStatus = status || "pending";

  const statusMap = {
    valid: {
      label: "Valid",
      badge: "bg-success text-light",
    },
    invalid: {
      label: "Perlu Perbaikan",
      badge: "bg-danger text-light",
    },
    pending: {
      label: "Belum Dicek",
      badge: "bg-warning text-dark",
    },
  };

  const meta = statusMap[safeStatus] || statusMap.pending;
  const isPdf = String(fileUrl).toLowerCase().endsWith(".pdf");

  let fileName = String(fileUrl).split("/").pop() || "";
  try {
    fileName = decodeURIComponent(fileName);
  } catch (error) {
    // biarkan nama asli bila escape sequence tidak valid
  }

  const safeUrl = escapeHtml(fileUrl);
  const safeLabel = escapeHtml(label);
  const safeFileName = escapeHtml(fileName);

  const thumb = isPdf
    ? `<div class="file-card-pdf"><i class="ri-file-pdf-2-line"></i></div>`
    : `<img src="${safeUrl}" alt="${safeLabel}" loading="lazy">`;

  const viewButton = isPdf
    ? `<button type="button" class="btn btn-sm btn-outline-primary view-pdf" data-file="${safeUrl}" title="Lihat dokumen">
         <i class="ri-eye-line"></i><span class="d-none d-xl-inline ms-1">Lihat</span>
       </button>`
    : `<div class="my-gallery" data-atlet-id="${atletId}">
         <a class="btn btn-sm btn-outline-primary view-img" href="${safeUrl}" target="_blank" rel="noopener" data-pswp-caption="${safeLabel}" title="Lihat dokumen">
           <i class="ri-eye-line"></i><span class="d-none d-xl-inline ms-1">Lihat</span>
         </a>
       </div>`;

  const notesButton = `
    <button type="button" class="btn btn-sm btn-outline-warning notes-file"
        data-label="${safeLabel}" data-id="${atletId}" data-type="${type}" title="Catatan validator">
        <i class="ri-sticky-note-add-line"></i><span class="d-none d-xl-inline ms-1">Catatan</span>
    </button>
  `;

  const adminButtons =
    (role === "admin" || role === "validator")
      ? `
    <button type="button" class="btn btn-sm btn-success validate-file"
        data-atlet-id="${atletId}" data-type="${type}" title="Tandai dokumen valid">
        <i class="ri-checkbox-circle-line"></i><span class="d-none d-xl-inline ms-1">Valid</span>
    </button>

    <button type="button" class="btn btn-sm btn-outline-danger invalidate-file"
        data-atlet-id="${atletId}" data-type="${type}" title="Tandai dokumen perlu perbaikan">
        <i class="ri-close-circle-line"></i><span class="d-none d-xl-inline ms-1">Invalid</span>
    </button>
  `
      : "";

  return `
    <div class="file-card" data-type="${type}" data-doc-status="${safeStatus}">
      <div class="file-card-thumb ${isPdf ? "is-pdf" : ""}">${thumb}</div>

      <div class="file-card-body">
        <div class="file-card-title">${safeLabel}</div>
        <div class="file-card-file" title="${safeFileName}">${safeFileName}</div>
        <span class="badge badge-status ${meta.badge}" data-type="${type}">${meta.label}</span>
      </div>

      <div class="file-card-actions">
        ${viewButton}
        ${adminButtons}
        ${notesButton}
      </div>
    </div>
  `;
}

/**
 * Kartu untuk dokumen wajib yang belum diunggah.
 * Membuat checklist verifikasi tetap lengkap tanpa perlu membuka data lain.
 */
function templateMissing(label, type, status) {
  const safeStatus = status || "pending";
  const isInvalid = safeStatus === "invalid";
  const safeLabel = escapeHtml(label);

  return `
    <div class="file-card is-missing" data-type="${type}" data-doc-status="${safeStatus}">
      <div class="file-card-thumb is-missing">
        <i class="ri-upload-cloud-2-line"></i>
      </div>

      <div class="file-card-body">
        <div class="file-card-title">${safeLabel}</div>
        <div class="file-card-file">Belum diunggah</div>
        <span class="badge badge-status ${isInvalid ? "bg-danger text-light" : "bg-secondary text-light"}" data-type="${type}">
          ${isInvalid ? "Perlu Perbaikan" : "Belum Ada Berkas"}
        </span>
      </div>

      <div class="file-card-actions">
        <span class="file-card-hint"><i class="ri-information-line"></i> Menunggu unggahan</span>
      </div>
    </div>
  `;
}

/**
 * Daftar dokumen wajib sesuai jenjang pendidikan.
 * Ijazah hanya wajib untuk selain SD / MI.
 * kk_status sengaja diabaikan (tidak muncul di checklist).
 */
window.getRequiredDocs = function getRequiredDocs(bentuk) {
  const docs = [
    { key: 'akte_status',      label: 'Akte Kelahiran',   type: 'akte' },
    { key: 'foto_status',      label: 'Foto Atlet',        type: 'foto' },
    { key: 'ktp_kia_kk_status', label: 'KTP / KIA / KK',   type: 'ktp_kia_kk' },
    { key: 'nisn_status',      label: 'Kartu NISN',        type: 'nisn' },
    { key: 'suket_status',     label: 'Surat Keterangan',  type: 'suket' }
  ];

  if (!['SD', 'MI'].includes(String(bentuk || ''))) {
    docs.splice(4, 0, { key: 'ijazah_status', label: 'Ijazah', type: 'ijazah' });
  }

  return docs;
};

/**
 * Hitung status final dari status dokumen.
 */
window.hitungStatusFinal = function hitungStatusFinal(validasi, bentuk) {
  validasi = validasi || {};
  const required = getRequiredDocs(bentuk);
  let hasInvalid = false;
  let hasPending = false;

  required.forEach(function(doc) {
    const status = validasi[doc.key] || 'pending';
    if (status === 'invalid') hasInvalid = true;
    if (status !== 'valid') hasPending = true;
  });

  return hasInvalid ? 'invalid' : (hasPending ? 'pending' : 'valid');
};

/**
 * Render ringkasan verifikasi (progress bar + teks + badge header).
 */
window.renderVerificationSummary = function renderVerificationSummary(validasi, bentuk) {
  validasi = validasi || {};

  const required = getRequiredDocs(bentuk);
  let valid = 0;
  let invalid = 0;

  required.forEach(function(doc) {
    const status = validasi[doc.key] || 'pending';
    if (status === 'valid') valid++;
    else if (status === 'invalid') invalid++;
  });

  const total = required.length;
  const percent = total ? Math.round((valid / total) * 100) : 0;

  const $bar = $('#v-doc-progress-bar');
  $bar.css('width', percent + '%')
    .removeClass('bg-success bg-warning bg-danger')
    .addClass(invalid > 0 ? 'bg-danger' : (percent === 100 ? 'bg-success' : 'bg-warning'));

  $('#v-doc-progress-text').text(valid + ' dari ' + total + ' dokumen valid');
  $('#v-doc-progress-percent').text(percent + '%');

  const $header = $('#v-header-status').removeClass('bg-success bg-danger bg-warning bg-secondary text-light text-dark');

  if (invalid > 0) {
    $header.addClass('bg-danger text-light').text('Perlu Perbaikan');
  } else if (percent === 100) {
    $header.addClass('bg-success text-light').text('Valid');
  } else {
    $header.addClass('bg-warning text-dark').text('Belum Lengkap');
  }
};

/**
 * Perbarui status kartu dokumen secara individual.
 */
window.setDocCardStatus = function setDocCardStatus(type, status) {
  const meta = (function() {
    if (status === 'valid') return { label: 'Valid', cls: 'bg-success text-light' };
    if (status === 'invalid') return { label: 'Perlu Perbaikan', cls: 'bg-danger text-light' };
    return { label: 'Belum Dicek', cls: 'bg-warning text-dark' };
  })();

  const card = document.querySelector('#file-gallery .file-card[data-type="' + type + '"]');
  if (card) {
    card.dataset.docStatus = status || 'pending';
  }

  const badge = document.querySelector('#file-gallery .badge-status[data-type="' + type + '"]');
  if (badge) {
    badge.className = 'badge badge-status ' + meta.cls;
    badge.textContent = meta.label;
  }
};

/**
 * Perbarui badge status final di baris tabel Data Atlet.
 */
window.updateAtletRowStatus = function updateAtletRowStatus(atletId, statusFinal) {
  const $badge = $('.badge-status-depan[data-id="' + atletId + '"]');
  if (!$badge.length) return;

  if (statusFinal === 'valid') {
    $badge.removeClass().addClass('badge badge-status-depan bg-success text-light').text('Sudah');
  } else if (statusFinal === 'invalid') {
    $badge.removeClass().addClass('badge badge-status-depan bg-danger text-light').text('Perlu Perbaikan');
  } else {
    $badge.removeClass().addClass('badge badge-status-depan bg-warning text-dark').text('Belum');
  }
};

/**
 * Toast ringan untuk aksi verifikasi. Tidak memblokir alur kerja.
 */
window.showGalleryToast = function showGalleryToast(message, type) {
  if (!window.bootstrap || !bootstrap.Toast) return;

  const id = 'galleryToastContainer';
  let container = document.getElementById(id);

  if (!container) {
    container = document.createElement('div');
    container.id = id;
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    container.style.zIndex = '20000';
    document.body.appendChild(container);
  }

  const variants = {
    success: { cls: 'text-bg-success', icon: 'ri-checkbox-circle-line' },
    danger: { cls: 'text-bg-danger', icon: 'ri-error-warning-line' },
    warning: { cls: 'text-bg-warning', icon: 'ri-error-warning-line' },
    info: { cls: 'text-bg-primary', icon: 'ri-information-line' }
  };
  const meta = variants[type] || variants.success;

  const toastEl = document.createElement('div');
  toastEl.className = 'toast align-items-center border-0 ' + meta.cls;
  toastEl.setAttribute('role', 'alert');
  toastEl.setAttribute('aria-live', 'assertive');
  toastEl.setAttribute('aria-atomic', 'true');
  toastEl.innerHTML =
    '<div class="d-flex">' +
      '<div class="toast-body d-flex align-items-center gap-2">' +
        '<i class="' + meta.icon + '"></i>' +
        '<span>' + escapeHtml(message) + '</span>' +
      '</div>' +
      '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>' +
    '</div>';

  // Batasi tumpukan toast agar tidak menutupi modal saat beberapa aksi cepat.
  const visibleToasts = container.querySelectorAll('.toast');
  if (visibleToasts.length >= 3) {
    visibleToasts[0].remove();
  }

  container.appendChild(toastEl);
  toastEl.addEventListener('hidden.bs.toast', function() {
    toastEl.remove();
  });

  bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 2400, autohide: true }).show();
};

function gallerySetDoc(type, status) {
  window.setDocCardStatus(type, status);

  const bentuk = $('#viewAtletModal').data('bentuk') || '';
  const validasi = {};

  $('#file-gallery .file-card').each(function() {
    const t = $(this).data('type');
    const s = String($(this).attr('data-doc-status') || 'pending');
    if (t) validasi[t + '_status'] = s;
  });

  window.renderVerificationSummary(validasi, bentuk);
}

function galleryValidateDoc(btn, status) {
  const atletId = btn.data('atlet-id');
  const type = btn.data('type');
  if (!atletId || !type) return;

  const label = btn.closest('.file-card').find('.file-card-title').text().trim() || 'Dokumen';
  btn.prop('disabled', true);

  $.ajax({
    url: window.ATLET_VALIDASI_DOKUMEN_URL,
    method: 'GET',
    data: {
      atletID: atletId,
      dok: type + '_status',
      status: status
    },
    global: false
  }).done(function(res) {
    res = res || {};
    gallerySetDoc(type, status);

    if (res.status_final) {
      window.updateAtletRowStatus(atletId, res.status_final);
    }

    if (status === 'valid') {
      window.showGalleryToast(label + ' divalidasi.', 'success');
    } else {
      window.showGalleryToast('Validasi ' + label + ' dicabut.', 'warning');
    }
  }).fail(function() {
    window.showGalleryToast('Status dokumen gagal diperbarui.', 'danger');
  }).always(function() {
    btn.prop('disabled', false);
  });
}

/**
 * Event handler memakai delegated event di document, sehingga tetap bekerja
 * walaupun kartu dokumen dirender ulang secara dinamis.
 */
function bindGalleryEvents() {
  const $doc = $(document);

  $doc.off('click.galleryValidate', '.validate-file')
    .on('click.galleryValidate', '.validate-file', function(e) {
      e.preventDefault();
      galleryValidateDoc($(this), 'valid');
    });

  $doc.off('click.galleryInvalidate', '.invalidate-file')
    .on('click.galleryInvalidate', '.invalidate-file', function(e) {
      e.preventDefault();
      galleryValidateDoc($(this), 'invalid');
    });

  $doc.off('click.galleryPdf', '.view-pdf')
    .on('click.galleryPdf', '.view-pdf', function(e) {
      e.preventDefault();
      const url = $(this).data('file');
      if (url) {
        window.open(url, '_blank', 'noopener');
      }
    });

  $doc.off('click.galleryNotes', '.notes-file')
    .on('click.galleryNotes', '.notes-file', function(e) {
      e.preventDefault();

      const btn = $(this);
      $('#modalNotes .modal-title').text('Catatan ' + btn.data('label'));
      $('#modalNotes').modal('show');

      const atletID = btn.data('id');
      const type = btn.data('type');
      const dok_catatan = type + '_catatan';

      $('#note-type').val(dok_catatan);
      $('#note-text').val('');

      $.ajax({
        url: window.ATLET_NOTES_GET_URL,
        method: 'POST',
        data: {
          atlet_id: atletID,
          dok_catatan: dok_catatan
        },
        success: function(res) {
          if (res && res[dok_catatan]) {
            $('#note-text').val(res[dok_catatan]);
          }
        }
      });
    });

  $doc.off('click.gallerySaveNote', '#save-note')
    .on('click.gallerySaveNote', '#save-note', function() {
      const btn = $(this);
      const atletId = $('#viewAtletModal').data('atlet-id');
      const dok = $('#note-type').val();
      const note = $('#note-text').val();

      if (!atletId || !dok) return;

      btn.prop('disabled', true);

      $.post(window.ATLET_SIMPAN_CATATAN_URL, {
        atlet_id: atletId,
        dok_catatan: dok,
        note_value: note
      }).done(function(res) {
        res = res || {};
        if (res.status !== 'success') {
          window.showGalleryToast(res.message || 'Catatan gagal disimpan.', 'danger');
          return;
        }

        $('#modalNotes').modal('hide');
        window.showGalleryToast('Catatan berhasil disimpan.', 'success');
      }).fail(function(xhr) {
        let message = 'Catatan gagal disimpan.';
        try {
          message = (xhr.responseJSON && xhr.responseJSON.message) || message;
        } catch (e) {}
        window.showGalleryToast(message, 'danger');
      }).always(function() {
        btn.prop('disabled', false);
      });
    });
}

// Tetap kompatibel dengan pemanggil lama.
window.reInitGallery = function reInitGallery() {
  bindGalleryEvents();
};

// Bind sekali saat halaman siap; cukup untuk elemen yang dirender belakangan.
$(function() {
  bindGalleryEvents();
});
