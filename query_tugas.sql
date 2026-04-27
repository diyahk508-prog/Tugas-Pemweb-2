
-- =========================
-- 1. STATISTIK BUKU (5 QUERY)
-- =========================

-- Menghitung jumlah seluruh buku dalam tabel
SELECT COUNT(*) AS total_buku FROM buku;

-- Menghitung total nilai inventaris (harga × stok semua buku)
SELECT SUM(harga * stok) AS total_inventaris FROM buku;

-- Menghitung rata-rata harga semua buku
SELECT AVG(harga) AS rata_rata_harga FROM buku;

-- Menampilkan buku dengan harga paling mahal
SELECT judul, harga 
FROM buku
ORDER BY harga DESC
LIMIT 1;

-- Menampilkan buku dengan jumlah stok terbanyak
SELECT judul, stok
FROM buku
ORDER BY stok DESC
LIMIT 1;


-- =========================
-- 2. FILTER DAN PENCARIAN (5 QUERY)
-- =========================

-- Menampilkan buku kategori Programming dengan harga di bawah 100000
SELECT * FROM buku
WHERE kategori = 'Programming' AND harga < 100000;

-- Menampilkan buku yang judulnya mengandung kata "PHP" atau "MySQL"
SELECT * FROM buku
WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';

-- Menampilkan buku yang terbit pada tahun 2024
SELECT * FROM buku
WHERE tahun_terbit = 2024;

-- Menampilkan buku dengan stok antara 5 sampai 10
SELECT * FROM buku
WHERE stok BETWEEN 5 AND 10;

-- Menampilkan buku yang ditulis oleh Budi Raharjo
SELECT * FROM buku
WHERE pengarang = 'Budi Raharjo';


-- =========================
-- 3. GROUPING DAN AGREGASI (3 QUERY)
-- =========================

-- Mengelompokkan buku berdasarkan kategori dan menghitung jumlah buku serta total stok
SELECT kategori, COUNT(*) AS jumlah_buku, SUM(stok) AS total_stok
FROM buku
GROUP BY kategori;

-- Menghitung rata-rata harga buku pada setiap kategori
SELECT kategori, AVG(harga) AS rata_rata_harga
FROM buku
GROUP BY kategori;

-- Menampilkan kategori dengan total nilai inventaris terbesar
SELECT kategori, SUM(harga * stok) AS total_inventaris
FROM buku
GROUP BY kategori
ORDER BY total_inventaris DESC
LIMIT 1;


-- =========================
-- 4. UPDATE DATA (2 QUERY)
-- =========================

-- Menaikkan harga semua buku kategori Programming sebesar 5%
UPDATE buku
SET harga = harga * 1.05
WHERE kategori = 'Programming';

-- Menambahkan stok sebanyak 10 untuk buku yang stoknya kurang dari 5
UPDATE buku
SET stok = stok + 10
WHERE stok < 5;


-- =========================
-- 5. LAPORAN KHUSUS (2 QUERY)
-- =========================

-- Menampilkan daftar buku yang perlu restocking (stok kurang dari 5)
SELECT * FROM buku
WHERE stok < 5;

-- Menampilkan 5 buku dengan harga paling mahal
SELECT judul, harga
FROM buku
ORDER BY harga DESC
LIMIT 5;
```
