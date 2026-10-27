-- =====================================================================
-- Bersihkan nomor cabor atlet yang tersimpan dobel di beberapa kolom.
-- Kasus: nomor_cabor_1 = nomor_cabor_2 (76 atlet), atau nomor_cabor_2 = nomor_cabor_3.
-- Dampak sebelumnya: atlet muncul 2x di Rekap Data (baris tabel & kartu).
--
-- Jalankan SETELAH backup database. Aman diulang (idempotent): kalau sudah
-- bersih, query WHERE tidak menemukan baris apa pun.
-- =====================================================================

-- 1) Hapus nomor kosong / bernilai 0
UPDATE atlet SET nomor_cabor_2 = NULL WHERE nomor_cabor_2 = 0;
UPDATE atlet SET nomor_cabor_3 = NULL WHERE nomor_cabor_3 = 0;

-- 2) nomor_cabor_2 sama dengan nomor_cabor_1
UPDATE atlet
SET nomor_cabor_2 = NULL
WHERE nomor_cabor_1 IS NOT NULL
  AND nomor_cabor_2 IS NOT NULL
  AND nomor_cabor_2 = nomor_cabor_1;

-- 3) nomor_cabor_3 sama dengan nomor_cabor_1 atau nomor_cabor_2
UPDATE atlet
SET nomor_cabor_3 = NULL
WHERE nomor_cabor_3 IS NOT NULL
  AND (
        (nomor_cabor_1 IS NOT NULL AND nomor_cabor_3 = nomor_cabor_1)
     OR (nomor_cabor_2 IS NOT NULL AND nomor_cabor_3 = nomor_cabor_2)
  );

-- 4) Rapikan: kolom 2 kosong tapi kolom 3 terisi -> geser ke kolom 2
UPDATE atlet
SET nomor_cabor_2 = nomor_cabor_3,
    nomor_cabor_3 = NULL
WHERE nomor_cabor_2 IS NULL
  AND nomor_cabor_3 IS NOT NULL;

-- 5) Verifikasi: harus 0 baris
SELECT COUNT(*) AS sisa_duplikat
FROM atlet
WHERE (nomor_cabor_1 <> 0 AND nomor_cabor_1 = nomor_cabor_2)
   OR (nomor_cabor_1 <> 0 AND nomor_cabor_1 = nomor_cabor_3)
   OR (nomor_cabor_2 <> 0 AND nomor_cabor_2 = nomor_cabor_3);
