function templateFile(label, fileUrl, status, type, atletId) {
  // Badge status
  var badge = {
    valid: `<span class="badge badge-status bg-success" data-type="${type}">Valid</span>`,
    invalid: `<span class="badge badge-status bg-danger" data-type="${type}">Tidak Sesuai</span>`,
    pending: `<span class="badge badge-status bg-warning text-dark" data-type="${type}">Belum Dicek</span>`,
  }[status ?? "pending"];

  var isPdf = fileUrl.toLowerCase().endsWith(".pdf");

  // Thumbnail / icon
  var thumb = !isPdf
    ? `<img src="${fileUrl}" width="80" class="rounded border" style="cursor:pointer;">`
    : `<div class="text-center"><i class="ri-file-pdf-2-line fs-1 text-danger"></i></div>`;

  return `
    <div class="border rounded p-3 mb-3">
        <div class="d-flex align-items-center">
            <div class="me-3">${thumb}</div>
            <div class="flex-grow-1"><div class="fw-bold">${label}</div>${badge}</div>

            <!-- Tombol View -->
            ${
              isPdf
                ? `<button class="btn btn-sm btn-outline-primary me-2 view-pdf" data-file="${fileUrl}">
                       <i class="ri-eye-line"></i> Lihat
                   </button>`
                : `<div class="my-gallery" data-atlet-id="${atletId}">
                       <a class="btn btn-sm btn-outline-primary me-2 view-img" 
                          href="${fileUrl}" 
                          data-pswp-caption="${label}">
                          <i class="ri-eye-line"></i> Lihat
                       </a>
                   </div>`
            }

            <!-- Validasi -->
            <button class="btn btn-sm btn-outline-success me-2 validate-file"
                data-atlet-id="${atletId}" data-type="${type}">
                <i class="ri-checkbox-circle-line"></i> Valid
            </button>

            <button class="btn btn-sm btn-outline-danger me-2 invalidate-file"
                data-atlet-id="${atletId}" data-type="${type}">
                <i class="ri-close-circle-line"></i> Invalid
            </button>

            <!-- Catatan -->
            <button class="btn btn-sm btn-outline-warning notes-file"
                data-label="${label}" data-id="${atletId}" data-type="${type}">
                <i class="ri-sticky-note-add-line"></i> Catatan
            </button>
        </div>
    </div>
    `;
}
