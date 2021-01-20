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
                <a class="h1"><b>Enviar Invitación de Registro</b></a>
            </div>
        
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="register-box-msg">Ingresa Correo Electrónico a Registrar</p>

                <form method="POST" action="{{ route('sendEmail.register') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input placeholder="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Enviar Link
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
