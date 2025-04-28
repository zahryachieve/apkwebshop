<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <title>Aplikasi</title>
    <link rel="icon" href="{{ asset('adminlte/img/iconlg.png') }}" type="image/gif" sizes="16x16">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .kotak_login {
            border: 0;
            width: 350px;
            background: white;
            border-radius: 9px;
            margin: 50px auto;
            padding: 30px 20px;
            border: 1px solid #e2e2e2;
        }

        .form_login {
            background: rgb(255, 255, 255);
            margin: 10px auto;
            border: 1px solid #e2e2e2;
            box-sizing: border-box;
            border-radius: 5px;
            width: 100%;
            padding: 14px 10px;
            font-size: 11pt;
        }

        .tombol_login {
            background: linear-gradient(to right, #87CEFA, #0000FF);
            /* Gradien biru muda ke biru tua */
            color: white;
            font-size: 11pt;
            width: 100%;
            margin: 9px auto;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .tombol_login[type="submit"]:hover {
            background: blue;
            font-size: 20px;
        }

    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('error'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('
            error ') }}',
            icon: 'error',
            confirmButtonText: 'Coba Lagi'
        });

    </script>
    @endif

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Logout Berhasil!',
            text: '{{ session('
            success ') }}', 
            icon: 'success',
            confirmButtonText: 'OK'
        });

    </script>
    @endif

    <div class="d-flex flex-column justify-content-center w-100 h-100">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="kotak_login">
                <center><img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8gdNrKPyr4qIaNuam3hHx6AUZorfCJlUeKQ&s"
                        alt="" width="30%"></center>
                <br>
                <div class="text-center">
                    <h3>Login</h3>
                </div>
                <form action="postlogin" method="POST">
                    @csrf
                    <div class="container mt-5" style="max-width: 400px;">
                        <!-- Input Email -->
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="name@gmail.com"
                                    required>
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                                <input id="password" type="password" name="password" class="form-control"
                                    placeholder="password" required>
                                <div class="input-group-append">
                                    <span id="togglePassword" class="input-group-text" style="cursor: pointer;">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Button Login -->
                        <button type="submit" class="btn btn-primary w-100">Login</button>

                        <!-- Forgot Password -->
                        <div class="text-end mt-2">
                            <a href="/forgot-password" class="text-decoration-none">Forgot Password?</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            var passwordInput = document.getElementById("password");
            var toggleIcon = this.querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        });

    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>