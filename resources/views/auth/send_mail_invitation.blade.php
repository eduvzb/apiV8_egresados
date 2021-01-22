<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>

    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="navbar  navbar-dark bg-primary navbar-expand-lg" style="height: 100px;"></div>
    
    <main class="container">
        <div class="row">
            <div class="col-md-7 mx-auto">
                <div class="card card-outline " style="top: -4.0rem;">
                    <div class="card-header">
                        <p class="h3">Enviar Invitación de Registro</p>
                    </div>

                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                            <img src="assets/img/tecnm.png" style="width:31%; height: 40%;">
                            <img src="assets/img/icon.png" style="width:15%;">
                        </div>

                        <div class="card-text pt-4">
                            <form method="POST" action="{{ route('sendEmail.register') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                                            Enviar Link De Invitación
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

<script src="/js/app.js"></script>
</body>
</html>
