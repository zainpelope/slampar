<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Warga Slampar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-custom {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Selamat Datang di SiPeDes Slampar</h1>
        <p>Silahkan pilih opsi login di bawah ini:</p>
        <a href="login.php" class="btn btn-primary btn-custom">Warga - Login Disini</a>
        <a href="admin/login.php" class="btn btn-success btn-custom">Perangkat Desa - Login Disini</a>
    </div>
</body>

</html>