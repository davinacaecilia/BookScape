# BookScape

Kelompok 5 :
- **Putri Sahara Tampubolon** - 241402015 - *Frontend Landing Page, Halaman Login, Halaman Registrasi, Halaman Home User*
- **Anggun Dwikasih Mahrani** - 241402018 - *Frontend Halaman Admin*
- **Dhaifina Raiqa Zahira** - 241402036 - *Backend Auth User dan Admin (Alur Login/Register dan Logout), Proses Rating dan Review Buku oleh User, Rating dan Review Management Admin, Edit Profil User (Nama, Email, No. HP, Alamat)*
- **Davina Caecilia Marpaung** - 241402076 - *Backend CRUD Product Buku, Alur Pemesanan User (Add to Cart, Checkout, Payment, Histori Order), Order Management Admin*
- **Jelita Amy Syafira Rangkuti** - 241402114 - *Frontend User Halaman List Buku, Preview Buku, History Pemesanan, Cart, Payment*

## About BookScape

BookScape adalah platform jual buku dengan fitur standar yang memudahkan pembeli dalam mencari dan membeli buku tanpa fitur kompleks yang tidak diperlukan. BookScape menawarkan kemudahan pembayaran yang selamat, penghantaran yang cepat, serta ciri-ciri tambahan seperti ulasan pengguna. Dengan menyediakan berbagai pilihan buku dari berbagai genre, pelanggan dapat mencari dan membeli buku dengan mudah tanpa gangguan. Fokus utama adalah untuk memberi pengalaman membeli dimana pengguna bisa mempercayai, tanpa kerumitan proses jualan dari pihak ketiga, menjadikan pembelian buku lebih mudah dan efisien bagi pembeli.

Adapun fitur-fitur yang tersedia dalam website BookScape antara lain :
- **Pencarian Buku**: Fitur ini memungkinkan pengguna untuk mencari judul buku yang diinginkan
- **Fitur Keranjang**: Fitur ini memungkinkan pengguna untuk menambahkan buku yang diinginkan ke dalam keranjang dan menghapus buku dari keranjang
- **Check Out Buku**: Fitur ini memungkinkan pengguna untuk melakukan check out buku yang diinginkan dari keranjang
- **Print Invoice**: Fitur ini memungkinkan pengguna untuk mencetak invoice pembelian buku yang telah dilakukan
- **Rating dan Review**: Fitur ini memungkinkan pengguna untuk memberikan rating dan review buku
- **Histori Pemesanan**: Fitur ini memungkinkan pengguna untuk melihat riwayat pemesanan buku yang telah dilakukan

## Getting Started

BookScape adalah website yang kami buat menggunakan :
- **Composer v2.8.6**: Package manager PHP (untuk membuat project laravel)
- **Laravel v12.14.1** sebagai framework PHP untuk membangun aplikasi web
- **PHP v8.4.4** sebagai bahasa pemrograman
- **MySQL v15.1** sebagai database
- **XAMPP v3.3.0** sebagai server
- **HTML, CSS, dan JavaScript** untuk membuat tampilan dan interaktivitas website
- **Boxicons** sebagai library icon

### Prerequisites

- **PHP**, minimal versi 8.1
- **XAMPP atau Laragon**
- **Composer**
- **MySQL atau MariaDB**

### Installing

Untuk menjalankan web ini, langkah-langkah yang perlu dilakukan adalah sebagai berikut :

Clone repository ini ke dalam direktori yang diinginkan

    git clone https://github.com/davinacaecilia/BookScape.git

Masuk ke dalam folder proyek

    cd BookScape

Install dependensi PHP melalui Composer, pastikan Composer sudah terinstall

    composer install

Jika Composer belum diinstall : https://getcomposer.org/download/

Buat salinan file .env.example menjadi .env

    cp .env.example .env

Generate App Key

    php artisan key:generate

Atur file .env sesuai dengan konfigurasi database lokalmu

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=root
    DB_PASSWORD=

Jalankan migrasi database

    php artisan migrate

Jalankan server

    php artisan serve


### Running Website

Selanjutnya, Anda perlu membuat symbolic link (tautan simbolis) dari direktori storage/app/public ke direktori public/storage. Ini memungkinkan file yang disimpan di direktori storage/app/public dapat diakses secara publik melalui URL.

    php artisan storage:link
    
Jika setelah melakukan link Anda tidak menemukan folder sampul dan folder bukti dalam folder storage/app/public Anda, silahkan buat folder tersebut secara manual. Langkah ini penting agar Anda dapat mengupload file ke direktori tersebut saat proses menambah buku dan memasukkan bukti pembayaran.

Untuk mengakses halaman pengguna, silahkan Sign Up terlebih dahulu dengan mengisi form registrasi yang tersedia. Setelah melakukan Sign Up, Anda dapat seterusnya melakukan Sign In untuk mengakses halaman pengguna dengan akun yang sama.

Untuk mengakses halaman admin, silahkan jalankan perintah berikut di terminal

    php artisan db:seed

Kemudian Anda dapat Sign In sebagai admin :

    Username = Admin
    Email = admin@gmail.com
    Password = Admin123