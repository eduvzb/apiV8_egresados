@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">

            <div class="card" style="border:1px solid">
                <div class="card-header">
                    <h2 class="card-title">Filtrado</h2>
                    <form name="filterform" action="{{route('tramite.filtrar')}}">
                        <div class="row">
                            <div class="col-md-11 offset-md-1">
                                <div class="row">
                                    
                                    <div class="col-md-3 form-group">
                                        <div class="form-group">
                                            <label>Trámites</label>
                                            @if($tramiteSelected == ' ')
                                            <select onchange="submitForm()" name="tramite" id="tramite" class="form-control col-md-13">
                                                <option value="">Seleccione un Trámite</option>
                                                @foreach($listaTramites as $tramite)
                                                    <option value="{{$tramite->name}}">{{$tramite->name}}</option>
                                                @endforeach
                                            </select>
                                            @else
                                            <select onchange="submitForm()" name="tramite" id="tramite" class="form-control col-md-13">
                                                <option value="">Seleccione un trámite</option>
                                                <option value="{{$tramiteSelected}}" selected>{{$tramiteSelected}}</option>
                                                @foreach($listaTramites as $tramite)
                                                    @if($tramiteSelected != $tramite->name)
                                                    <option value="{{$tramite->name}}">{{$tramite->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <div class="form-group">
                                            <label>Carreras</label>
                                            @if($carreraSelected == ' ')
                                            <select onchange="submitForm()" name="carrera" id="carrera" class="form-control col-md-13">
                                                <option value="">Seleccione una Carrera</option>
                                                @foreach($carreras as $carrera)
                                                    <option value="{{$carrera->name}}">{{$carrera->name}}</option>
                                                @endforeach
                                            </select>
                                            @else
                                            <select onchange="submitForm()" name="carrera" id="carrera" class="form-control col-md-13">
                                                <option value="">Selecciona una Carrera</option>
                                                <option value="{{$carreraSelected}}" selected>{{$carreraSelected}}</option>
                                                @foreach($carreras as $carrera)
                                                    @if($carreraSelected != $carrera->name)
                                                    <option value="{{$carrera->name}}">{{$carrera->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <div class=" text-center">
                                            <label for="radioSpeci">Año
                                                <input type="radio" name="specificDate" id="radioByYear" onclick="visibleYear()">
                                            </label>
                                        </div>
                                        
                                        <div id="divByYear" class="text-center">
                                            <div class="form-group">
                                                <label for="">Año de Ingreso: </label>
                                                    @if($yearIngresoSelected == ' ')
                                                    <select onchange="submitForm()" class="form-control" name="yearIngreso" id="">
                                                        <option value="">Selecciona Año de Ingreso</option>
                                                        @foreach($yearsIngreso as $yearIngreso)
                                                        <option value="{{$yearIngreso}}">{{$yearIngreso}}</option>
                                                        @endforeach
                                                    </select>
                                                    @else
                                                    <select onchange="submitForm()" class="form-control" name="yearIngreso" id="">
                                                        <option value="">Selecciona Año de Ingreso</option>
                                                        <option value="{{$yearIngresoSelected}}" selected>{{$yearIngresoSelected}}</option>
                                                        @foreach($yearsIngreso as $yearIngreso)
                                                            @if($yearIngreso != $yearIngresoSelected)
                                                                <option value="{{$yearIngreso}}">{{$yearIngreso}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @endif
                                            </div>

                                            <div>
                                                <label for="">Año de Egreso: </label>
                                                @if($yearEgresoSelected == ' ')
                                                <select onchange="submitForm()" class="form-control" name="yearEgreso" id="">
                                                    <option value="">Seleccione un Año de Egreso</option>
                                                    @foreach($yearsEgreso as $yearEgreso)
                                                    <option value="{{$yearEgreso}}">{{$yearEgreso}}</option>
                                                    @endforeach
                                                </select>
                                                @else
                                                <select onchange="submitForm()" class="form-control" name="yearEgreso" id="">
                                                    <option value="">Seleccione un Año de Egreso</option>
                                                    <option value="{{$yearEgresoSelected}}" selected>{{$yearEgresoSelected}}</option>
                                                    @foreach($yearsEgreso as $yearEgreso)
                                                        @if($yearEgresoSelected != $yearEgreso)
                                                            <option value="{{$yearEgreso}}">{{$yearEgreso}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <div class=" text-center">
                                            <label for="radioRange">Rango de Fechas
                                                <input type="radio" name="rangeDate" id="radioRange" onclick="hideSpeci()">
                                            </label>
                                        </div>
                                        <div id="divRange">
                                            <div id="divRange" class="form-group">
                                                <label for="">Fecha de Ingreso: </label>
                                                <input value="{{$dateRangeIngreso}}" id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fechaIngresoRange">
                                            </div>
                                            <div>
                                                <label for="">Fecha de Egreso: </label>
                                                <input value="{{$dateRangeEgreso}}" class="form-control" type="date" name="fechaEgresoRange">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <div class=" text-center">
                                            <label for="radioSpeci">Fecha Específica
                                                <input type="radio" name="specificDate" id="radioSpeci" onclick="hideRange()">
                                            </label>
                                        </div>
                                        <div id="divSpeci">
                                            <div class="form-group">
                                                <label for="">Fecha de Ingreso: </label>
                                                <input value="{{$dateSpeIngreso}}" id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fechaIngresoSpe">
                                            </div>
                                            <div>
                                                <label for="">Fecha de Egreso: </label>
                                                <input value="{{$dateSpeEgreso}}" class="form-control" type="date" name="fechaEgresoSpe" id="">
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="container text-right">
                        <form action="{{route('tramites_emails',[
                        'tramite' => $tramiteSelected, 
                        'carrera' => $carreraSelected,
                        'yearIngreso' => $yearIngresoSelected,
                        'yearEgreso'  => $yearEgresoSelected,
                        'dateIngresoRange' => $dateRangeIngreso,
                        'dateEgresoRange'  => $dateRangeEgreso,
                        'dateIngresoSpe' => $dateSpeIngreso,
                        'dateEgresoSpe'  => $dateSpeEgreso
                        ])}}">
                                <abbr title="Enviar Correos"><button class="btn btn-warning"><i class="material-icons">email</i></button></abbr>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Egresados Con Trámites</h3>
                    <div class="container text-right">
                        <form action="{{route('download.tramites',[
                        'tramite' =>$tramiteSelected,
                        'carrera' => $carreraSelected,
                        'yearIngreso' => $yearIngresoSelected,
                        'yearEgreso'  => $yearEgresoSelected,
                        'dateIngresoRange' => $dateRangeIngreso,
                        'dateEgresoRange'  => $dateRangeEgreso,
                        'dateIngresoSpe' => $dateSpeIngreso,
                        'dateEgresoSpe'  => $dateSpeEgreso
                        ])}}">
                            <abbr title="Descargar Egresados Con Trámites Como Archivo Excel">
                            <button type="submit" class="btn btn-success"><i class="material-icons">save_alt</i></button></abbr>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                    <table id="example1" class="text-center table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido Paterno</th>
                                <th scope="col">Apellido Materno</th>
                                <th scope="col">No. de Control</th>
                                <th scope="col">Trámite</th>
                                <th scope="col">Carrera</th>
                                <th scope="col" style="width: 180px">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach ($tramites as $tramite)
                        <tr>
                            <td scope="row">{{$tramite->name}}</td>
                            <td scope="row">{{$tramite->apellido1}}</td>
                            <td scope="row">{{$tramite->apellido2}}</td>
                            <td scope="row">{{$tramite->noControl}}</td>
                            <td scope="row">{{$tramite->tipo}}</td>
                            <td scope="row">{{$tramite->carrera}}</td>
                            <td>
                                <a href="{{route('egresados.tramites',$tramite->egresado_id)}}" class="btn btn-info btn-sm">
                                    Ver Trámite
                                </a>
                                @if($tramite->finalizado)
                                    <a onclick="confirmation(event,true)" href="{{route('tramite.finish',$tramite->id)}}" class="btn btn-success btn-sm">
                                        Reiniciar
                                    </a>
                                @else
                                    <a onclick="confirmation(event,false)" href="{{route('tramite.finish',$tramite->id)}}" class="btn btn-danger btn-sm">
                                        Finalizar
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$tramites->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function confirmation(ev,estado){
        if(estado){
            var mensaje = "Reiniciar";
            var msj = "Reiniciado";
        }
        else{
            var mensaje = "Concluir";
            var msj = "Concluido";
        }
        ev.preventDefault();
        var url = ev.currentTarget.getAttribute('href');
        console.log(url);
        Swal.fire({
            title: '¿Estás Seguro que deseas dar ' + mensaje + ' el Trámite?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:'Cancelar',
            confirmButtonText: 'Sí, '+ mensaje + '!'
        }).then((result) => {
            if (result.value) {
                axios.get(url).then(result => {
                    Swal.fire({
                        title: msj+'!',
                        text:'El Trámite ha sido '+msj+'.',
                        icon:'success',
                    })
                    .then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire(
                    'Ocurrió un error!',
                    'El Trámite no ha sido concluido.',
                    'error');
                });
            }
        })
    }
</script>
@endsection

<script>
    function submitForm(){
        document.filterform.submit();
    }
</script>