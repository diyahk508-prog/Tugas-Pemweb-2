
-- 1. TABEL KATEGORI_BUKU

CREATE TABLE kategori_buku (
  id_kategori   INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(50)  NOT NULL UNIQUE,
  deskripsi     TEXT,
  is_deleted    TINYINT(1)   NOT NULL DEFAULT 0,
  created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- 2. TABEL PENERBIT

CREATE TABLE penerbit (
  id_penerbit   INT AUTO_INCREMENT PRIMARY KEY,
  nama_penerbit VARCHAR(100) NOT NULL,
  alamat        TEXT,
  telepon       VARCHAR(15),
  email         VARCHAR(100),
  is_deleted    TINYINT(1)   NOT NULL DEFAULT 0,
  created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- 4. TABEL BUKU (MODIFIKASI 
CREATE TABLE buku_modifikasi (
  id_buku INT AUTO_INCREMENT PRIMARY KEY,
  kode_buku VARCHAR(20) NOT NULL UNIQUE,
  judul VARCHAR(200) NOT NULL,
  id_kategori INT NOT NULL,
  id_penerbit INT NOT NULL,
  id_rak INT DEFAULT NULL,
  pengarang VARCHAR(100) NOT NULL,
  tahun_terbit INT NOT NULL,
  isbn VARCHAR(20),
  harga DECIMAL(10,2) NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  deskripsi TEXT,
  is_deleted TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
  FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
);

-- INSERT DATA: KATEGORI BUKU (7 kategori)

INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Programming',  'Buku-buku tentang pemrograman dan pengembangan perangkat lunak'),
('Database',     'Buku-buku tentang basis data dan manajemen data'),
('Web Design',   'Buku-buku tentang desain dan pengembangan web'),
('Networking',   'Buku-buku tentang jaringan komputer dan keamanan'),
('Data Science', 'Buku-buku tentang analisis data, machine learning, dan AI'),
('Mobile Dev',   'Buku-buku tentang pengembangan aplikasi mobile'),
('DevOps',       'Buku-buku tentang DevOps, CI/CD, dan cloud computing');


-- INSERT DATA: PENERBIT (7 penerbit)

INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Informatika', 'Jl. Setiabudi No. 65, Bandung',         '022-2034207',      'info@informatika.co.id'),
('Graha Ilmu',  'Jl. Raden Saleh No. 1A, Yogyakarta',    '0274-515194',      'info@grahailmu.co.id'),
('Andi',        'Jl. Beo No. 38-40, Yogyakarta',         '0274-561881',      'info@andipublisher.com'),
('Elex Media',  'Jl. Palmerah Barat No. 29-33, Jakarta', '021-5305006',      'info@elexmedia.co.id'),
('Oreilly',     'Sebastopol, California, USA',           '+1-707-827-7000',  'info@oreilly.com'),
('Packt',       'Livery Place, Birmingham, UK',          '+44-121-2655-800', 'info@packtpub.com'),
('Deepublish',  'Jl. Rajawali No. 14, Yogyakarta',       '0274-560525',      'info@deepublish.co.id');


-- INSERT DATA: BUKU 
INSERT INTO buku_modifikasi
(kode_buku, judul, id_kategori, id_penerbit, pengarang, tahun_terbit, isbn, harga, stok, deskripsi)
VALUES
('BK001','Belajar PHP Dasar',        1, 1, 'Budi Raharjo', 2024, '978000001',  90000, 5, 'Dasar pemrograman PHP'),
('BK002','Mastering MySQL',          2, 4, 'Andi Setiawan',2023, '978000002', 120000, 7, 'Pengelolaan database MySQL'),
('BK003','Modern Web Design',        3, 3, 'Rina Sari',    2024, '978000003',  95000, 6, 'Desain UI/UX web modern'),
('BK004','Jaringan Komputer',        4, 2, 'Eko Prasetyo', 2022, '978000004',  80000, 4, 'Dasar jaringan komputer'),
('BK005','Data Science dengan Python',5, 5,'Dewi Lestari', 2023, '978000005', 150000, 3, 'Analisis data & ML'),

('BK006','Android Development',      6, 7, 'Budi Raharjo', 2024, '978000006', 110000, 8, 'Pengembangan aplikasi Android'),
('BK007','DevOps Fundamentals',      7, 6, 'Andi Setiawan',2023, '978000007', 130000, 9, 'CI/CD dan cloud'),
('BK008','Laravel untuk Pemula',     1, 3, 'Rina Sari',    2024, '978000008', 115000,10, 'Framework Laravel'),
('BK009','PostgreSQL Guide',         2, 2, 'Eko Prasetyo', 2023, '978000009', 105000, 6, 'Database PostgreSQL'),
('BK010','UI/UX Design Principles',  3, 4, 'Dewi Lestari', 2024, '978000010',  85000, 5, 'Desain antarmuka'),

('BK011','Network Security',         4, 5, 'Budi Raharjo', 2022, '978000011', 140000, 2, 'Keamanan jaringan'),
('BK012','Machine Learning Basics',  5, 6, 'Andi Setiawan',2023, '978000012', 160000, 5, 'Dasar ML'),
('BK013','Flutter Mobile Apps',      6, 7, 'Rina Sari',    2024, '978000013', 125000, 4, 'Aplikasi Flutter'),
('BK014','Cloud DevOps',             7, 5, 'Eko Prasetyo', 2023, '978000014', 135000, 3, 'DevOps di cloud'),
('BK015','Java Programming',         1, 1, 'Dewi Lestari', 2024, '978000015', 145000, 7, 'Pemrograman Java');

-- =========================
-- 1. JOIN: Buku + Kategori + Penerbit
-- =========================
-- Menampilkan data buku beserta nama kategori dan penerbit
SELECT 
    b.kode_buku,
    b.judul,
    b.pengarang,
    b.harga,
    b.stok,
    k.nama_kategori,
    p.nama_penerbit
FROM buku_modifikasi b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;


-- =========================
-- 2. JUMLAH BUKU PER KATEGORI
-- =========================
-- Menghitung jumlah buku di setiap kategori
SELECT 
    k.nama_kategori,
    COUNT(b.id_buku) AS jumlah_buku
FROM buku_modifikasi b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
GROUP BY k.nama_kategori;


-- =========================
-- 3. JUMLAH BUKU PER PENERBIT
-- =========================
-- Menghitung jumlah buku di setiap penerbit
SELECT 
    p.nama_penerbit,
    COUNT(b.id_buku) AS jumlah_buku
FROM buku_modifikasi b
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
GROUP BY p.nama_penerbit;


-- =========================
-- 4. DETAIL LENGKAP BUKU
-- =========================
-- Menampilkan semua informasi buku + kategori + penerbit
SELECT 
    b.*,
    k.nama_kategori,
    p.nama_penerbit
FROM buku_modifikasi b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;