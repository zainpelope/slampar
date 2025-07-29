<?php
include '../koneksi.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['id_admin'] = $row['id_admin'];
            $_SESSION['email'] = $row['email'];

            header("Location: ../index_admin.php?admin=home_admin");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1abcac;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #f7f7f7;
            font-size: 16px;
        }

        .form-input:focus {
            outline: none;
            border-color: #4e73df;
            background-color: #fff;
        }

        .show-password {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .show-password input {
            margin-right: 5px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #3e60c4;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: gray;
        }

        .login-btn,
        .back-btn {
            background-color: #1abcac;
            /* Same color as the login button */
            color: white;
            border: none;
            padding: 12px 20px;
            width: 100%;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        .login-btn:hover,
        .back-btn:hover {
            background-color: #17a59e;
            /* Slightly darker shade for hover effect */
        }

        .back-btn {
            background-color: #f0f0f0;
            /* Light gray background */
            color: #333;
            /* Dark text */
            border: 1px solid #ccc;
            /* Border style */
        }

        .back-btn:hover {
            background-color: #ddd;
            /* Darker background on hover */
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" class="form-input" placeholder="Email" required><br>
            <input type="password" name="password" class="form-input" placeholder="Password" required><br>
            <div class="show-password">
                <input type="checkbox" id="show-password"> <label for="show-password">Show Password</label>
            </div>
            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <button type="submit" class="login-btn">Login</button>
            <a href="../slampang.php"><button type="button" class="back-btn">Back</button></a>
        </form>



    </div>

    <script>
        document.getElementById("show-password").addEventListener("change", function() {
            const passwordField = document.querySelector('input[name="password"]');
            if (this.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        });
    </script>
</body>

</html>