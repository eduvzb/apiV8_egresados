@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

        <!--
        <div class="card " style="border:1px solid">
            <div class="card-header">
                <h2 class="card-title">Nueva Cita</h2>
            </div>

            <div class="card-body">
                

                    
                    <div class="col-md-8 form-group">
                        
                        <div class="form-group">
                            <label for="cita">Mensaje:</label>
                            <textarea name="mensaje" id="mensaje" cols="8" rows="3" class="form-control @error('mensaje') is-invalid @enderror"></textarea>
                            @error('mensaje')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cita">Asunto:</label>
                            <input name="asunto" id="asunto" type="text" class="form-control @error('asunto') is-invalid @enderror"></input>
                            @error('mensaje')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cita">Examinar Archivo:</label>
                            <input name="file" class="form-control" id="formFile" type="file">
                        </div>
                        <a onclick="clearFile()" class="btn btn-warning">Borrar Archivo</a>  
                    </div>

                    <div class="col-md-4 form-group">
                        <div class="form-group">
                            <label for="cita">Fecha de cita:</label>
                            <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha">
                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="hora">Hora de cita:</label>
                            <input id="hora" type="time" class="form-control @error('hora') is-invalid @enderror" name="hora">
                                @error('hora')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary">Enviar Seleccionados</button>
                            <a onclick="back()" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
            </div>
        </div>
        -->
        
        <div class="card">
                <div class="card-header">

                    <form class="row g-3" action="{{route('citas.enviarPendientes')}}"  method="POST" enctype="multipart/form-data">
                    @csrf

                    <h1 class="card-title">Reenviar Citas No Enviadas</h1>
                    <div class="col-md-12 form-group text-right">
                        <div class="text-right">
                            <button class="btn btn-primary">Reenviar Seleccionados</button>
                            <a onclick="back()" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive-md">
                        <table class="text-center table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Destino</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Asunto</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Seleccionar</th>
                                    <th scope="col" style="width: 100px">Opciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($citas as $cita)
                                <tr>
                                    <td>{{$cita->destino}}</td>
                                    <td>{{$cita->mensaje}}</td>
                                    <td>{{$cita->asunto}}</td>
                                    <td>{{$cita->fecha}}</td>
                                    <td>{{$cita->hora}}</td>
                                    <td scope="row"><input type="checkbox" name="option[]" id="checkbox" value="{{$cita->id}}" checked></td>
                                    <td>
                                        <a href="{{route('egresados.tramites', $cita->id)}}" class="btn btn-info btn-sm">
                                            <abbr title="Enviar"><i class="material-icons">email</i></abbr>
                                        </a>
                                        <a href="{{route('egresados.delete',$cita->id)}}" class="btn btn-danger btn-sm">
                                            <abbr title="Eliminar Trámite"><i class="material-icons">delete</i></abbr>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>    
        </div>
    </div>
</div>
@endsection

<script>
        function back(){
            window.history.back();
        }

        function clearFile(){
            document.getElementById('formFile').value=""
        }
</script>