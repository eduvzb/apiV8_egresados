<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="hold-transition login-page">

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a class="h1"><b>Inicio de Sesión</b></a>
        </div>
    
        <div class="card-body">
            <p class="login-box-msg">Ingresa Correo Electrónico y Contraseña</p>

            <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="input-group mb-3">
                <input id="email" placeholder="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="material-icons">email</span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                <input id="password" placeholder="contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="material-icons">lock</span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Recordar Usuario</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>
        
            @if (Route::has('password.request'))
                <a class="text-center" href="{{ route('password.request') }}">
                    Olvidaste Tu Contraseña?
                </a>
            @endif
        </div>
    </div>
</div>

<script src="/js/app.js"></script>
</body>
</html>