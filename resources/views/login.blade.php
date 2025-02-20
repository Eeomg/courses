<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Log in</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href={{asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>
        body {
            background: url('{{ asset('images/login-background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            color: white;
        }

        .login-logo b {
            color: #ffcc00;
            font-size: 24px;
        }

        .card {
            background: transparent;
            border: none;
        }

        .card-body {
            padding: 20px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #ffcc00, #ff8800);
            border: none;
            color: black;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #ff8800, #ffcc00);
            transform: scale(1.05);
        }

        input.form-control {
            background: transparent; /* يجعل الخلفية شفافة */
            border: none; /* إزالة جميع الحدود */
            border-bottom: 2px solid rgba(255, 255, 255, 0.5); /* حد سفلي فقط */
            color: white; /* لون النص */
            transition: border-bottom 0.3s ease-in-out; /* تأثير انسيابي عند التغيير */
            border-radius: 0; /* إزالة التدوير */
        }

        input.form-control:focus {
            border-bottom: 2px solid #ffcc00; /* تغيير لون الحد السفلي عند التركيز */
            outline: none; /* إزالة التوهج الأزرق الافتراضي */
            box-shadow: none; /* إزالة أي ظل افتراضي */
        }

        input.form-control::placeholder {
            color: rgba(255, 255, 255, 0.7); /* لون النص الوصفي */
        }

        .input-group-text {
            background: transparent; /* إزالة الخلفية */
            border: none; /* إزالة الحدود */
            color: white; /* لون الأيقونة */
        }


        .alert-danger {
            background: rgba(255, 0, 0, 0.2);
            border: none;
            color: white;
        }

        .login-box-msg {
            font-size: 16px;
            font-weight: bold;
        }

        a {
            color: #ffcc00;
            transition: 0.3s ease-in-out;
        }

        a:hover {
            color: #ff8800;
        }
    </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>{{\App\Models\Setting::where('key','name')->first()->value}}</b> Platform
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            @if($errors->has('login'))
                <div class="alert alert-danger">
                    {{ $errors->first('login') }}
                </div>
            @endif
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
