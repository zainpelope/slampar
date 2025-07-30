<?php
// api_reset_password.php
include '../koneksi.php';

header('Content-Type: application/json'); // Penting: Memberi tahu klien bahwa respons adalah JSON

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari input JSON atau form-data
    // Untuk API, lebih umum menerima JSON, tetapi karena form asli POST biasa, kita pakai $_POST
    $nama = $_POST['nama'] ?? '';
    $nik = $_POST['nik'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $email = $_POST['email'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi_password_baru = $_POST['konfirmasi_password_baru'] ?? '';

    // Validasi input
    if (empty($nama) || empty($nik) || empty($tanggal_lahir) || empty($email) || empty($password_baru) || empty($konfirmasi_password_baru)) {
        $response['message'] = "Semua kolom harus diisi!";
    } elseif ($password_baru !== $konfirmasi_password_baru) {
        $response['message'] = "Password baru dan konfirmasi password tidak cocok!";
    } else {
        // Gunakan prepared statements untuk mencegah SQL Injection
        $stmt = $conn->prepare("SELECT id FROM warga WHERE nama = ? AND nik = ? AND tanggal_lahir = ? AND email = ?");
        if ($stmt === false) {
            $response['message'] = "Gagal menyiapkan statement SELECT: " . $conn->error;
        } else {
            $stmt->bind_param("ssss", $nama, $nik, $tanggal_lahir, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $user_id = $user['id'];

                // SANGAT PENTING: Dalam aplikasi nyata, gunakan password_hash() untuk meng-hash password
                // Contoh: $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
                // Lalu simpan $hashed_password ke database.
                // Untuk konsistensi dengan kode login Anda saat ini yang tidak menggunakan hashing,
                // saya akan menyimpan password dalam bentuk teks biasa.
                // MOHON SANGAT DIREKOMENDASIKAN UNTUK MENGUBAH INI DI LINGKUNGAN PRODUKSI!
                $update_stmt = $conn->prepare("UPDATE warga SET password = ? WHERE id = ?");
                if ($update_stmt === false) {
                    $response['message'] = "Gagal menyiapkan statement UPDATE: " . $conn->error;
                } else {
                    $update_stmt->bind_param("si", $password_baru, $user_id); // Ganti $password_baru dengan $hashed_password jika menggunakan hashing

                    if ($update_stmt->execute()) {
                        $response['success'] = true;
                        $response['message'] = "Password berhasil direset! Silakan login dengan password baru Anda.";
                    } else {
                        $response['message'] = "Terjadi kesalahan saat mereset password: " . $update_stmt->error;
                    }
                    $update_stmt->close();
                }
            } else {
                $response['message'] = "Data yang Anda masukkan tidak cocok dengan catatan kami.";
            }
            $stmt->close();
        }
    }
} else {
    $response['message'] = "Metode request tidak diizinkan. Gunakan POST.";
}

// Menutup koneksi database
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}

echo json_encode($response); // Mengembalikan respons dalam format JSON
