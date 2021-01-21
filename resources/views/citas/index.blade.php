@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <div class="card" style="border:1px solid">
                        <div class="card-header">
                            <h2 class="card-title">Nueva Cita</h2>
                        </div>

                        <div class="card-body">
                            <form class="row g-3" method="POST" enctype="multipart/form-data" action="{{route('citar',$id)}}">
                            @csrf
                                <div class="col-md-8">
                                    <label for="cita">Mensaje:</label>
                                    <textarea name="mensaje" id="mensaje" cols="8" rows="3" class="form-control @error('mensaje') is-invalid @enderror"></textarea>
                                    @error('mensaje')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <label for="cita">Asunto:</label>
                                    <input name="asunto" id="asunto" type="text" class="form-control @error('asunto') is-invalid @enderror"></input>
                                    @error('asunto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="cita">Fecha de cita:</label>
                                    <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha">
                                        @error('fecha')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    <p></p>
                                    <label for="hora">Hora de cita:</label>
                                    <input id="hora" type="time" class="form-control @error('hora') is-invalid @enderror" name="hora">
                                        @error('hora')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="cita">Examinar Archivo:</label>
                                            <input name="file" class="form-control" id="formFile" type="file">
                                            <p></p>
                                            <a onclick="clearFile()" class="btn btn-warning">Borrar Archivo</a>
                                        </div>
                                        
                                        <div class="col align-self-end">
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                            <a onclick="back()" class="btn btn-danger btn-delete">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Citas</h1>
                    </div>

                    <div class="card-body">
                        <table class="text-center table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col" style="width: 150px">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($citas as $cita)
                                <tr>
                                    <td>{{$cita->descripcion}}</td>
                                    <td>{{$cita->fecha}}</td>
                                    <td>{{$cita->hora}}</td>
                                    <td>
                                        <a onclick="confirmation(event)" href="{{route('citas.delete',$cita->id)}}">
                                            <button class="btn btn-danger btn-sm btn-delete">Eliminar</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function confirmation(ev){
        ev.preventDefault();
        var url = ev.currentTarget.getAttribute('href');
        console.log(url);
        Swal.fire({
            title: '¿Estás Seguro que deseas eliminar la Cita?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:'Cancelar',
            confirmButtonText: 'Sí, Eliminarla!'
        }).then((result) => {
            if (result.value) {
                axios.get(url).then(result => {
                    Swal.fire({
                        title:'Eliminada!',
                        text:'La cita ha sido eliminada.',
                        icon:'success',
                    })
                    .then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire(
                    'Ocurrió un error!',
                    'La cita no ha sido eliminada.',
                    'error');
                });
            }
        })
    }
</script>
@endsection

<script>
        function back(){
            window.history.back();
        }

        function clearFile(){
            document.getElementById('formFile').value=""
        }
</script>

