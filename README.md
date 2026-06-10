# 🌸 Flora - AI-Powered Florist E-Commerce

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Gemini AI](https://img.shields.io/badge/Gemini_AI-1.5_Flash-4285F4?style=for-the-badge&logo=google-gemini)](https://ai.google.dev/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)](https://www.php.net)
[![Laravel Reverb](https://img.shields.io/badge/Laravel_Reverb-Websockets-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com/docs/11.x/reverb)

**Flora** adalah platform E-commerce toko bunga modern yang dibangun dengan Laravel 12. Proyek ini dilengkapi dengan **Flora Bot**, asisten virtual cerdas berbasis AI (Google Gemini) yang membantu pelanggan memilih rangkaian bunga terbaik berdasarkan momen spesial mereka, memberikan pengalaman belanja yang lebih personal dan interaktif.

---

## 🚀 Fitur Utama

-   **🛍️ Katalog Produk Dinamis:** Manajemen produk dan kategori yang mudah melalui dashboard admin. Produk dapat ditandai sebagai "unggulan" untuk ditampilkan di halaman utama.
-   **🤖 Flora Bot (Asisten AI):** 
    -   **Integrasi Google Gemini:** Menggunakan model `gemini-1.5-flash` untuk respons yang cepat dan kontekstual.
    -   **Rekomendasi Cerdas:** Memberikan saran produk berdasarkan input bahasa natural dari pengguna (misal: "bunga untuk wisuda di bawah 300 ribu").
    -   **Penanganan Error Cerdas:** Memiliki sistem *fallback* yang ramah jika kuota API habis (HTTP 429) atau terjadi error, memastikan UX tetap baik.
-   **🛒 Sistem Keranjang Belanja:** Alur belanja yang *seamless* dari penambahan produk hingga checkout.
-   **⚡ Real-time Chat:** Interaksi dengan Flora Bot terasa instan berkat **Laravel Reverb**, server WebSocket performa tinggi yang terintegrasi.
-   **📱 Dasbor Admin Komprehensif:**
    -   Manajemen CRUD untuk Produk, Kategori, dan Banner.
    -   Manajemen Pesanan (Order Management) dengan pembaruan status.
    -   Moderasi Ulasan (Review) dari pelanggan.
    -   Pengaturan situs umum, termasuk informasi kontak dan SEO.

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

-   **Framework:** Laravel 12
-   **Bahasa:** PHP 8.2
-   **Frontend:** Blade Engine, Tailwind CSS 4.x, Vite
-   **AI Layer:** Google Gemini API (v1beta)
-   **Real-time:** Laravel Reverb (Websockets)
-   **Database:** MySQL / SQLite
-   **Testing:** PHPUnit (Unit & Feature Testing)
-   **Code Styling:** Laravel Pint

---

## 🏛️ Arsitektur Proyek

Proyek ini mengadopsi arsitektur **Monolithic** dengan pola **MVC (Model-View-Controller)**, yang diperkaya dengan beberapa pola desain untuk meningkatkan keterbacaan dan pemeliharaan kode:

-   **Service Layer:** Logika bisnis yang kompleks (misalnya, interaksi dengan API Gemini, kalkulasi keranjang) dienkapsulasi dalam *Service Class* (cth: `GeminiService`, `CartService`). Ini membuat *Controller* tetap ramping.
-   **Repository Pattern (Partial):** Terdapat `SettingRepository` yang mengabstraksi logika pengambilan data pengaturan, memisahkan sumber data dari bagian aplikasi lainnya.
-   **Contracts (Interfaces):** Penggunaan *interface* seperti `AIChatServiceInterface` memungkinkan *dependency inversion*, sehingga implementasi AI dapat diganti (misal: ke OpenAI) tanpa mengubah *Controller* yang menggunakannya.

```
/app
├── Contracts/       # Interfaces (AIChatServiceInterface)
├── Events/          # Event & Listener classes
├── Http/
│   ├── Controllers/ # Controllers (Admin & Catalog)
│   └── Requests/    # Form Request Validation
├── Models/          # Model Eloquent
├── Providers/       # Service Providers
├── Repositories/    # Repository classes (SettingRepository)
└── Services/        # Business logic (GeminiService, CartService)
```

---

## 📦 Instalasi dan Konfigurasi

### Prasyarat
-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Database (MySQL, atau SQLite untuk development)

### Langkah-langkah Instalasi
1.  **Clone Repository**
    ```bash
    git clone https://github.com/Fajri2301/tokobunga.git
    cd tokobunga
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    -   Salin file `.env.example` menjadi `.env`.
        ```bash
        cp .env.example .env
        ```
    -   Buat kunci aplikasi baru.
        ```bash
        php artisan key:generate
        ```
    -   Atur koneksi database dan API Key Gemini Anda di dalam file `.env`:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=tokobunga
        DB_USERNAME=root
        DB_PASSWORD=

        GEMINI_API_KEY=your_google_ai_studio_key
        GEMINI_MODEL=gemini-1.5-flash
        ```

4.  **Migrasi dan Seeding Database**
    Jalankan migrasi untuk membuat tabel dan (opsional) seeder untuk mengisi data awal.
    ```bash
    php artisan migrate --seed
    ```

5.  **Build Aset Frontend**
    ```bash
    npm run build
    ```

---

## 🚀 Menjalankan Aplikasi

### Mode Development (Rekomendasi)
Proyek ini dilengkapi dengan skrip `concurrently` untuk menjalankan semua layanan yang dibutuhkan secara bersamaan dalam satu perintah.

```bash
npm run dev
```
Perintah di atas akan menjalankan:
-   PHP development server (`php artisan serve`)
-   Vite untuk hot-reloading aset frontend
-   Laravel Reverb WebSocket server (`php artisan reverb:start`)
-   Queue worker (`php artisan queue:listen`)
-   Log tailer (`php artisan pail`)

### Mode Produksi Sederhana
1.  **Jalankan Web Server:**
    ```bash
    php artisan serve
    ```
2.  **Jalankan Reverb Server (di terminal terpisah):**
    ```bash
    php artisan reverb:start --host=0.0.0.0 --port=8080
    ```
3.  **Jalankan Queue Worker (di terminal terpisah):**
    ```bash
    php artisan queue:work
    ```
---

## 🧪 Pengujian (Testing)

Proyek ini dilengkapi dengan serangkaian tes otomatis untuk memastikan kualitas dan keandalan kode.

**Menjalankan Seluruh Rangkaian Tes:**
```bash
php artisan test
```

**Pengecekan Code Style (Tanpa Mengubah File):**
```bash
vendor/bin/pint --test
```

**Memperbaiki Code Style Secara Otomatis:**
```bash
vendor/bin/pint
```

---

## 🤝 Panduan Kontribusi

Kontribusi untuk pengembangan proyek ini sangat diharapkan. Berikut adalah panduan singkatnya:

1.  **Fork** repository ini.
2.  Buat *branch* baru untuk fitur atau perbaikan Anda (`git checkout -b fitur/nama-fitur`).
3.  Lakukan perubahan dan *commit* dengan pesan yang jelas.
4.  Pastikan semua tes berjalan dengan baik (`php artisan test`).
5.  Lakukan *Pull Request* ke branch `main` dari repository asli.

---
*Flora - Bringing Nature's Beauty to Your Doorstep with AI.* 🌸
