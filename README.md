
# MuslimApp

Aplikasi web Muslim modern berbasis Laravel untuk menampilkan Al-Qur'an, Jadwal Shalat, Al-Ma'surat, dan Arah Kiblat dengan deteksi lokasi otomatis.

---

## Fitur Utama
- **Jadwal Shalat Otomatis**: Deteksi lokasi user via browser, tampilkan jadwal shalat sesuai kota/provinsi secara otomatis.
- **Fallback Manual**: Jika lokasi gagal dideteksi, user dapat memilih provinsi dan kota secara manual.
- **Al-Qur'an Digital**: Baca, cari surah & ayat, dan tampilkan detail ayat.
- **Al-Ma'surat & Arah Kiblat**: Fitur siap dikembangkan.
- **UI Modern**: Responsive, animatif, dan mudah digunakan (Tailwind CSS, Vite).

---

## Instalasi
1. **Clone repository**
   ```bash
   git clone https://github.com/Bangkah/MuslimApp.git
   cd muslimApp
   ```
2. **Install dependency**
   ```bash
   composer install
   npm install
   ```
3. **Copy dan edit .env**
   ```bash
   cp .env.example .env
   # Edit konfigurasi database sesuai kebutuhan
   ```
4. **Generate key & migrate**
   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan db:seed --class=QuranSeeder
   ```
5. **Jalankan server**
   ```bash
   composer run dev
   ```

---

## API Endpoint
### Deteksi Lokasi
- `GET /api/detect-location?lat={latitude}&lon={longitude}`
  - Response: nama kota, provinsi, dan koordinat terdekat.

### Jadwal Shalat
- `GET /api/prayertime?lat={latitude}&lon={longitude}&date={YYYY-MM-DD}`
  - Response: jadwal shalat lengkap untuk lokasi dan tanggal tersebut.
- `GET /api/prayertime?city={nama_kota}&province={nama_provinsi}&date={YYYY-MM-DD}`
  - Response: jadwal shalat berdasarkan input manual.

### Al-Qur'an
- `GET /api/surahs` — Daftar surah
- `GET /api/surah/{id}` — Detail surah & ayat
- `GET /api/ayahs` — Daftar ayat
- `GET /api/ayah/{id}` — Detail ayat
- `GET /api/quran` — Semua data Quran
- `GET /api/search?q={kata}` — Pencarian ayat

---

## Struktur Folder Penting
- `app/Http/Controllers/Api/` — Seluruh controller API (jadwal shalat, deteksi lokasi, quran)
- `app/Models/City.php` — Model custom untuk data kota
- `resources/views/dashboard.blade.php` — Dashboard utama
- `resources/views/prayertime/index.blade.php` — Halaman jadwal shalat
- `routes/api.php` — Daftar endpoint API
- `routes/web.php` — Routing web frontend

---

## Cara Kerja Jadwal Shalat
1. **Frontend** otomatis mendeteksi lokasi user via browser.
2. **API** `/api/detect-location` mencari kota terdekat dari koordinat user.
3. **API** `/api/prayertime` mengembalikan jadwal shalat sesuai lokasi.
4. Jika gagal, user bisa input manual provinsi & kota.

---

## Testing
```bash
php artisan test
```

---

## Roadmap

* [ ] Searching ayat berbasis keyword
* [ ] Penandaan halaman Mushaf
* [ ] Streaming audio (Murattal)
* [ ] Bookmarking ayat
* [ ] Dokumentasi API otomatis (Swagger)
* [ ] Caching Redis untuk kecepatan tinggi

---

## Kontribusi

1. Fork repositori
2. Buat branch fitur:

   ```sh
   git checkout -b feature/fitur-baru
   ```
3. Commit perubahan:

   ```sh
   git commit -m "feat: menambahkan fitur X"
   ```
4. Push & buka Pull Request

---
