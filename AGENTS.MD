# PROMPT INSTRUKSI DEVELOPMENT: MILESTONE 1 (AUTH & MASTER DATA)

Halo AI, tolong bantu saya membuatkan fondasi awal untuk proyek aplikasi "Sistem Informasi Sentralisasi Data Produksi Ekspor".

Selesaikan tugas ini secara bertahap dengan mengikuti instruksi di bawah (gunakan penamaan tabel/kolom berbahasa Inggris penuh, tetapi isi data seeder menggunakan bahasa Indonesia):

---

## TUGAS 1: MIGRATIONS & SEEDERS (DATABASE MASTER)

Buatlah file migrasi database dan seeders untuk entitas berikut dengan relasi yang benar (RBAC & Branch):

1. Table: `roles`

    - Columns: id_role (PK), role_name (VARCHAR)
    - Seeder Data (Bahasa Indonesia):
        - 'Super Admin'
        - 'Admin Pusat'
        - 'Kepala Cabang'
        - 'Operator Produksi'
        - 'Tim Ekspor'

2. Table: `branches`

    - Columns: id_branch (PK), branch_name (VARCHAR), location (VARCHAR)
    - Seeder Data (Bahasa Indonesia):
        - 'Pusat' (Location: Kantor Pusat)
        - 'Cabang 1' (Location: Pabrik A)
        - 'Cabang 2' (Location: Pabrik B)

3. Table: `users`
    - Tambahkan column: id_role (FK -> roles), id_branch (FK -> branches, nullable)
    - Relasi Note: branch_id bernilai NULL jika role_name adalah 'Super Admin', 'Admin Pusat', atau 'Tim Ekspor'.
    - Seeder Data Akun Dummy untuk Testing:
        - Akun Super Admin (role: Super Admin, branch: NULL)
        - Akun Admin Pusat (role: Admin Pusat, branch: NULL)
        - Akun Kepala Cabang 1 (role: Kepala Cabang, branch: Cabang 1)
        - Akun Kepala Cabang 2 (role: Kepala Cabang, branch: Cabang 2)
        - Akun Operator Cabang 1 (role: Operator Produksi, branch: Cabang 1)
        - Akun Operator Cabang 2 (role: Operator Produksi, branch: Cabang 2)
        - Akun Tim Ekspor (role: Tim Ekspor, branch: NULL)

---

## TUGAS 2: FITUR AUTENTIKASI (LOGIN & SESSION)

1. Buatlah halaman Login sederhana (Form Username & Password).
2. Buatlah backend logic controller untuk memvalidasi login tersebut.
3. Setelah login berhasil, simpan informasi `username`, `role_name`, dan `branch_name` ke dalam session / token status (JWT/Auth State). Jika `id_branch` bernilai NULL, maka nama cabang otomatis di-set/ditampilkan sebagai "Pusat".

---

Tolong berikan kode yang clean, modular, dan jelaskan langkah instalasi atau penempatan filenya dengan runtut. Terima kasih!
