<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Analytics Portal</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3676dc, #1f08d3);
            height: 100vh;
        }

        .login-container {
            max-width: 502px; 
            width: 100%;
        }

        .login-card {
            border-radius: 15px;
            padding: 30px;
            background: #fff;
        }

        .form-control {
            border-radius: 10px;
            padding-left: 40px;
            height: 45px;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #6c757d;
        }

        .btn-login {
            border-radius: 10px;
            height: 45px;
            font-weight: 500;
        }

        .title {
            font-weight: 600;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="login-container">
        <div class="login-card shadow-lg">

            <div class="text-center mb-4">
                <h3 class="title text-primary">Student Analytics</h3>
                <p class="text-muted small">Login to your dashboard</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger small">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3 position-relative">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" class="form-control" name="email" placeholder="Email address" required>
                </div>

                <!-- Password -->
                <div class="mb-3 position-relative">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-primary w-100 btn-login">
                    Login
                </button>

                <div class="text-center mt-3">
                    <small class="text-muted">Forgot password?</small>
                </div>
            </form>

        </div>
    </div>

</body>
</html>