# Getting Started
The Dashboard Template is a versatile and modern dashboard solution built with a robust tech stack, including Laravel, Inertia.js, Vue 3, and styled with Tailwind CSS.

### Key Features:
-   Authentication & Authorization: Secure access control with role-based permissions.
-   Dynamic Datatables: Includes filtering, sorting, and searching functionalities for efficient data management.
-   Data Export: Easily export data to Excel and PDF formats.
-   Data Import: Supports importing data from Excel and Word files.

### Prerequisites
-   PHP 8.1 or higher
-   NodeJS 18.15 or higher
-   MySQL 5.7 or higher
-   Composer

### Installation
1. Clone the repository: `git clone https://github.com/username/my-application.git`
2. Install laravel dependencies: `composer install`
3. Install vue3js dependecies: `npm install`
4. Copy `.env.example` to `.env`
5. Generate key: `php artisan generate:key`
6. Set value for these keys: APP_NAME, APP_URL, and the database connection
7. Run migrations: `php artisan migrate --seed`
8. make symlink from storage to public: `php artisan storage:link`
9. Build the frontend: `npm run build`

### Link Documentation
1. laravel: `https://laravel.com/docs/10.x`
2. vue3js: `https://vuejs.org/guide`
3. inertiajs: `https://inertiajs.com/`
4. laravel routes in javascript: `https://github.com/tighten/ziggy`
5. laravel permissions: `https://spatie.be/docs/laravel-permission/v6/`
6. laravel filemanager: `https://github.com/UniSharp/laravel-filemanager`
7. tailwind css : `https://tailwindcss.com/docs`
8. tailwindcss component: `https://tailwindcomponents.com/components`
9. fontawesome for free icon: `https://fontawesome.com/search?o=r&m=free`

### Folder Structure

```
    └── 📁app
        └── 📁Exceptions           # Menyimpan file kelas untuk menangani pengecualian (exception) dalam aplikasi.
        └── 📁Http
            └── 📁Controllers      # Menyimpan semua controller yang mengelola permintaan HTTP dan mengarahkan logika bisnis.
            └── 📁Middleware       # Menyimpan middleware yang bertindak sebagai lapisan perantara dalam aplikasi.
                └── HandleInertiaRequests.php  # Contoh file middleware untuk menangani permintaan inertia.
                └── ...
            └── 📁Requests         # Menyimpan kelas untuk memvalidasi permintaan HTTP sebelum dikirim ke controller.
            └── 📁Resources        # Menyimpan resource yang digunakan untuk pengelolaan data API, seperti resource collection.
        └── 📁Models               # Menyimpan model Eloquent yang mewakili tabel database.
        └── 📁Providers            # Menyimpan service provider yang mengatur binding dependency dan layanan aplikasi.
    └── 📁bootstrap                # Menyimpan file untuk bootstrap aplikasi dan pengaturan auto-loading.
    └── 📁config                   # Menyimpan file konfigurasi aplikasi.
    └── 📁database
        └── 📁factories            # Menyimpan definisi factory untuk pembuatan model dalam pengujian.
        └── 📁migrations           # Menyimpan file migrasi database untuk pengelolaan skema tabel.
        └── 📁seeders              # Menyimpan file seeder untuk mengisi database dengan data awal.
    └── 📁public                   # Menyimpan file yang dapat diakses secara publik, seperti index.php, aset (CSS, JS), dll.
        └── 📁storage              # Menyimpan file yang dihasilkan secara publik, seperti upload file pengguna.
        └── 📁vendor               # vendor package untuk laravel-filemanager.
    └── 📁resources
        └── 📁css                  # Menyimpan file CSS untuk styling aplikasi.
        └── 📁js                   # Menyimpan file JavaScript untuk interaktivitas aplikasi.
            └── 📁Components       # Menyimpan komponen Vue.js yang digunakan dalam aplikasi.
                └── 📁Datatable    # Menyimpan komponen datatable untuk menampilkan data dalam tabel.
                └── 📁Elements     # Menyimpan komponen kecil dan reusable.
                └── 📁Fragments    # Menyimpan bagian dari halaman yang bisa digunakan kembali.
                └── 📁Templates    # Menyimpan template komponen Vue.js.
            └── 📁Layouts          # Menyimpan layout Vue.js untuk berbagai bagian aplikasi.
                └── AuthLayout.vue # Layout untuk halaman otentikasi.
                └── GuestLayout.vue # Layout untuk halaman tamu.
                └── MainLayout.vue  # Layout utama aplikasi.
                └── 📁guest-parts  # Menyimpan bagian layout khusus untuk halaman tamu.
                └── 📁main-parts   # Menyimpan bagian layout utama aplikasi.
            └── 📁Pages            # Menyimpan halaman Vue.js yang berbeda.
                └── 📁Admin        # Menyimpan halaman untuk admin.
                └── 📁Auth         # Menyimpan halaman untuk otentikasi.
                └── Error.vue      # Halaman untuk menampilkan pesan error.
                └── 📁Guest        # Menyimpan halaman untuk pengguna tamu.
                └── 📁Profile      # Menyimpan halaman profil pengguna.
            └── 📁Utils            # Menyimpan utilitas JavaScript yang digunakan dalam aplikasi.
        └── 📁views                # Menyimpan template blade yang digunakan untuk tampilan server-side.
    └── 📁routes                   # Menyimpan definisi rute untuk aplikasi.
    └── 📁storage                  # Menyimpan file yang dihasilkan aplikasi, seperti cache, logs, dan file yang diunggah.
```
