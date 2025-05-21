<?php
// login.controller.php
session_start();

// Konfigurasi database (sesuaikan dengan setting database Anda)
$host = 'localhost';
$dbname = 'nama_database_anda';
$username = 'username_database';
$password = 'password_database';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Inisialisasi array pesan
$message = [];

// Cek apakah form dikirim
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);

    // Validasi input
    if (empty($email)) {
        $message[] = 'Email harus diisi';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Format email tidak valid';
    }

    if (empty($password)) {
        $message[] = 'Password harus diisi';
    }

    // Jika tidak ada error validasi
    if (empty($message)) {
        try {
            // Cari pengguna di database
            $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $pengguna = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($pengguna) {
                // Verifikasi password (asumsi password disimpan dalam bentuk hash)
                if (password_verify($password, $pengguna['password'])) {
                    // Set session
                    $_SESSION['user_id'] = $pengguna['id'];
                    $_SESSION['user_email'] = $pengguna['email'];
                    $_SESSION['user_nama'] = $pengguna['nama']; // jika ada field nama
                    
                    // Redirect ke halaman dashboard
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $message[] = 'Password salah';
                }
            } else {
                $message[] = 'Email tidak ditemukan';
            }
        } catch (PDOException $e) {
            $message[] = 'Error database: ' . $e->getMessage();
        }
    }
}


require_once 'login.blade.php'; 
?>
