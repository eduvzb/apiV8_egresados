<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>

    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="hold-transition login-page">

    <div class="register-box">
        <div class="card card-outline card-primary">
            
            <div class="card-header text-center">
                <a class="h1"><b>Registro de Usuario</b></a>
            </div>
        
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="register-box-msg">Correo Electrónico y Contraseña</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-group mb-3">
                        <input id="email" placeholder="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autofocus>
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
                        <input id="password" placeholder="contraseña" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" name="password">
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

                    <div class="input-group mb-3">
                        <input id="password-confirm" placeholder="repetir contraseña" type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="material-icons">lock</span>
                            </div>
                        </div>
                        @error('password-confirm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

<script src="/js/app.js"></script>
</body>
</html>