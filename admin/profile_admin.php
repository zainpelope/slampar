<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php");
    exit();
}

$id_admin = $_SESSION['id_admin'];
$sql = "SELECT nama, email, password FROM admin WHERE id_admin = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if (!$admin) {
    echo "Admin tidak ditemukan.";
    exit();
}

// Generate random avatar
$avatar_url = "https://i.pravatar.cc/150?u=" . md5($admin['email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #343a40;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            margin-bottom: 1rem;
        }

        .profile-details {
            padding: 2rem;
        }

        .profile-details p {
            margin-bottom: 0.75rem;
        }

        .btn-container {
            padding: 1rem 2rem;
            text-align: center;
        }

        .btn-container .btn {
            margin: 0 0.5rem;
        }
    </style>
</head>

<body>
    <div class="card" style="max-width: 500px; width: 100%;">
        <div class="profile-header">
            <img src="<?php echo $avatar_url; ?>" alt="Avatar">
            <h4><?php echo htmlspecialchars($admin['nama']); ?></h4>
        </div>
        <div class="profile-details">
            <p><i class="fas fa-envelope me-2"></i> Email: <?php echo htmlspecialchars($admin['email']); ?></p>
            <p><i class="fas fa-key me-2"></i> Password: <span id="password-display"><?php echo str_repeat('*', strlen(htmlspecialchars($admin['password']))); ?></span> <button id="toggle-password" class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-eye"></i></button></p>
        </div>
        <div class="btn-container">
            <a href="edit_profile_admin.php" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Edit</a>
            <a href="../slampang.php" class="btn btn-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
            <a href="../index_admin.php?admin=home_admin" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz2"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordDisplay = document.getElementById('password-display');
            const togglePasswordButton = document.getElementById('toggle-password');
            let passwordHidden = true;

            togglePasswordButton.addEventListener('click', function() {
                if (passwordHidden) {
                    passwordDisplay.textContent = '<?php echo htmlspecialchars($admin['password']); ?>';
                    togglePasswordButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    passwordHidden = false;
                } else {
                    passwordDisplay.textContent = '<?php echo str_repeat("*", strlen(htmlspecialchars($admin['password']))); ?>';
                    togglePasswordButton.innerHTML = '<i class="fas fa-eye"></i>';
                    passwordHidden = true;
                }
            });
        });
    </script>
</body>

</html>