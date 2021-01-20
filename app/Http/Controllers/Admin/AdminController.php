<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Cita;
use App\Models\Tramite;
use App\Models\Egresado;
use App\Mail\EmailEgresados;
use App\Models\ListaCarrera;
use App\Models\ListaTramite;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Filter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function allEgresados(Request $request)
    {
        $carrera           = $request->carrera;
        $opcion            = $request->opcion;
        $opcionElegida     = $request->inputOption;
        $anioIngresado     = $request->yearIngreso;
        $anioEgresado      = $request->yearEgreso;
        $dateRangeIngreso  = $request->fechaIngresoRange;
        $dateRangeEgreso   = $request->fechaEgresoRange;
        $dateSpeIngreso    = $request->fechaIngresoSpe;
        $dateSpeEgreso     = $request->fechaEgresoSpe;

        $dates = [
            $dateRangeIngreso,
            $dateRangeEgreso,
            $dateSpeIngreso,
            $dateSpeEgreso,
            $anioIngresado,
            $anioEgresado
        ];

        $filterTramites = new Filter();
        $yearsIngreso   = $filterTramites->getYearsIngreso();
        $yearsEgreso    = $filterTramites->getYearsEgreso();
        $egresados      = $filterTramites->getEgresados($opcionElegida,$opcion,$carrera,$dates);
        
        $carreras  = ListaCarrera::all();

        if(!$carrera) $carrera = " ";
        if(!$anioIngresado) $anioIngresado = " ";
        if(!$anioEgresado) $anioEgresado = " ";
        if(!$dateRangeIngreso) $dateRangeIngreso = " ";
        if(!$dateRangeEgreso) $dateRangeEgreso = " ";
        if(!$dateSpeIngreso) $dateSpeIngreso = " ";
        if(!$dateSpeEgreso) $dateSpeEgreso = " ";

        return view('egresados.index',[
            'yearIngresoSelected' => $anioIngresado,
            'yearEgresoSelected'  => $anioEgresado,
            'dateRangeIngreso'    => $dateRangeIngreso,
            'dateRangeEgreso'     => $dateRangeEgreso,
            'dateSpeIngreso'      => $dateSpeIngreso,
            'dateSpeEgreso'       => $dateSpeEgreso,
            'yearsIngreso'        => $yearsIngreso,
            'yearsEgreso'         => $yearsEgreso,
            'egresados'           => $egresados,
            'carreras'            => $carreras,
            'career'             => $carrera,
        ]);
    }

    public function deleteEgresado($id)
    {
        $egresado = Egresado::where('id',$id);
        $egresado->delete();
        return redirect()->route('egresados');
    }

    public function getTramites($id)
    {
        $tramites = Tramite::where('egresado_id',$id)->get();
        return view('tramites.index',['tramites' => $tramites]);
    }

    public function getCreateTramite()
    {
        $listaTramites = ListaTramite::all();
        return view('tramites.create',[
            'tramites' => $listaTramites
        ]);
    }

    public function editListaTramite($id)
    {   
        $tramite = ListaTramite::where('id',$id)->first();
        return view('tramites.edit',['tramite' => $tramite]);
    }

    public function updateNameTramite(Request $request,$id)
    {
        $request->validate(['trámite' => 'required']);
        $tramite = ListaTramite::where('id',$id)->first();
        $tramite->name = $request->trámite;;
        $tramite->save();
        return redirect()->route('listaTramites');
    }
    
    public function storeTramite(Request $request)
    {   
        $validate = $request->validate(['trámite' => 'required']);
        $newTramite = ListaTramite::where('name',$request->trámite)->first();

        if(!$newTramite){
            $tramite = new ListaTramite();
            $tramite->name = $request->trámite;
            $tramite->save();
            return redirect()->back();
        }
        else return back()->withErrors([ 'trámite' => 'Trámite Existente' ]);
    }

    public function getMails($tramite,$carrera,$yearIngreso,$yearEgreso,$dateRangeIngreso,$dateRangeEgreso,$dateSpeIngreso,$dateSpeEgreso)
    {
        $dates = [
            $dateRangeIngreso,
            $dateRangeEgreso,
            $dateSpeIngreso,
            $dateSpeEgreso,
            $yearIngreso,
            $yearEgreso
        ];
        
        $filterEmails = new Filter();
        $egresados = $filterEmails->getTramites($tramite,$carrera,$dates);

        if(!$tramite) $tramite = " ";
        if(!$carrera) $carrera = " ";
        if(!$yearIngreso) $yearIngreso = " ";
        if(!$yearEgreso) $yearEgreso = " ";
        if(!$dateRangeIngreso) $dateRangeIngreso = " ";
        if(!$dateRangeEgreso) $dateRangeEgreso = " ";
        if(!$dateSpeIngreso)  $dateSpeIngreso = " ";
        if(!$dateSpeEgreso) $dateSpeEgreso = " ";

        return view('citas.mails',[
            'yearIngresoSelected' => $yearIngreso,
            'yearEgresoSelected'  => $yearEgreso,
            'dateRangeIngreso' => $dateRangeIngreso,
            'dateRangeEgreso'  => $dateRangeEgreso,
            'dateSpeIngreso' => $dateSpeIngreso,
            'dateSpeEgreso' => $dateSpeEgreso,
            'egresados' => $egresados,
            'carreraS'  => $carrera,
            'tramiteS'  => $tramite,
        ]);
    }

    public function sendEmails(Request $request,$tramite,$carrera,$yearIngreso,$yearEgreso,$dateRangeIngreso,$dateRangeEgreso,$dateSpeIngreso,$dateSpeEgreso)
    {   
        $request->validate([
            'mensaje' => 'required',
            'fecha'   => 'required',
            'hora'    => 'required',
            'asunto'  => 'required'
        ]);
        
        $selected = $request->only('option');
        $fails = false;
        
        $dates = [
            $dateRangeIngreso,
            $dateRangeEgreso,
            $dateSpeIngreso,
            $dateSpeEgreso,
            $yearIngreso,
            $yearEgreso
        ];

        $filterEmails = new Filter();

        if($selected)
            $egresadosSelected = $filterEmails->getMailsCheckbox($tramite,$carrera,$dates,$selected);
        else
            $egresadosSelected = $filterEmails->getMailsRestantes($tramite,$carrera,$dates,$selected);
        
        $data = [
            "mensaje" => $request->mensaje,
            "asunto"  => $request->asunto,
            "fecha"   => $request->fecha,
            "hora"    => $request->hora,
        ];

        if ($request->hasFile('file'))
            $data["file"] = $request->file('file');
        
        foreach ($egresadosSelected as $tramite){
            $user = Egresado::where('id',$tramite->egresado_id)->first()->user_id;
            $user = User::where('id',$user)->first()->email;
            $data["tramite"] = $tramite->tipo;

            try {
                \Mail::to($user)->send(new EmailEgresados($data));

                $cita = new Cita();
                $cita->tramite_id = $tramite->id;
                $cita->descripcion = $request->mensaje;
                $cita->fecha = $request->fecha;
                $cita->hora  = $request->hora;
                $cita->asunto = $request->asunto;
                $cita->save();
            } catch (\Throwable $th) {
                \DB::table('emails_not_sends')->insert([
                    'destino' => $user,
                    'mensaje' => $request->mensaje,
                    'tramite_id' => $tramite->id,
                    'fecha' => $request->fecha,
                    'hora'  => $request->hora,
                    'asunto' => $request->asunto
                ]);
                $fails = true;
            }
        }
        return redirect()->back()->with('status','Se han envíado Correctamente los Correos');
    }

    public function finishTramite($id)
    {
        $tramite = Tramite::where('id',$id)->first();
        if($tramite){
            $tramite->finalizado = !$tramite->finalizado;;
            $tramite->save();
        }
        return redirect()->route('egresados');
    }
    
    public function deleteTramite($id)
    {
        $tramite = Tramite::where('id',$id);
        $tramite->delete();
        return redirect()->back();
    }

    public function deleteListaTramite($id)
    {
        $tramites = ListaTramite::where('id',$id);
        $tramites->delete();
        return redirect()->back();
    }

    public function allTramites(Request $request)
    {   
        $tramite  = $request->tramite;
        $carrera  = $request->carrera;
        $anioIngresado = $request->yearIngreso;
        $anioEgresado  = $request->yearEgreso;
        $dateRangeIngreso = $request->fechaIngresoRange;
        $dateRangeEgreso  = $request->fechaEgresoRange;
        $dateSpeIngreso = $request->fechaIngresoSpe;
        $dateSpeEgreso = $request->fechaEgresoSpe;

        $dates = [
            $dateRangeIngreso,
            $dateRangeEgreso,
            $dateSpeIngreso,
            $dateSpeEgreso,
            $anioIngresado,
            $anioEgresado
        ];

        $filterTramites = new Filter();
        $yearsIngreso   = $filterTramites->getYearsIngreso();
        $yearsEgreso    = $filterTramites->getYearsEgreso();
        $tramites      = $filterTramites->getTramites($tramite,$carrera,$dates);

        $carreras = ListaCarrera::all();
        $listaTramites = ListaTramite::all();

        if(!$tramite) $tramite = " ";
        if(!$carrera) $carrera = " ";
        if(!$anioIngresado) $anioIngresado = " ";
        if(!$anioEgresado) $anioEgresado = " ";
        if(!$dateRangeIngreso) $dateRangeIngreso = " ";
        if(!$dateRangeEgreso) $dateRangeEgreso = " ";
        if(!$dateSpeIngreso)  $dateSpeIngreso = " ";
        if(!$dateSpeEgreso) $dateSpeEgreso = " ";

        return view('tramites.all',[ 
            'tramites' => $tramites,
            'carreras' => $carreras,
            'listaTramites' => $listaTramites,
            'yearsIngreso' => $yearsIngreso,
            'yearsEgreso'  => $yearsEgreso,
            'yearIngresoSelected' => $anioIngresado,
            'yearEgresoSelected' => $anioEgresado,
            'dateRangeIngreso'    => $dateRangeIngreso,
            'dateRangeEgreso'     => $dateRangeEgreso,
            'dateSpeIngreso'      => $dateSpeIngreso,
            'dateSpeEgreso'       => $dateSpeEgreso,
            'carreraSelected' => $carrera,
            'tramiteSelected' => $tramite
        ]);
    }

    public function allCitas(Request $request)
    {
        $tramite = $request->tramite;
        $carrera = $request->carrera;
        
        $citas = new Filter();
        $citas = $citas->getAllCitas($tramite,$carrera);

        $carreras = ListaCarrera::all();
        $tramites = ListaTramite::all();

        if(!$tramite) $tramite = '-';
        if(!$carrera) $carrera = '-';

        return $citas;

        return view ('citas.all',[ 
            'citas'    => $citas,
            'carreras' => $carreras,
            'tramites' => $tramites,
            'carreraS' => $carrera,
            'tramiteS' => $tramite,
        ]);
    }

    public function getCitas($id)
    {
        $citas = Cita::with('tramites')->where('tramite_id',$id)->get();
        return view('citas.index',['id' => $id,'citas' => $citas]);
    }

    public function postCitar(Request $request,$id)
    {
        $request->validate([
            'mensaje' => 'required',
            'fecha'   => 'required',
            'hora'    => 'required',
            'asunto'  => 'required'
        ]);

        $user = Tramite::where('id',$id)->first()->egresado_id;
        $user = Egresado::where('id',$user)->first()->user_id;
        $user = User::where('id',$user)->first()->email;
        $tramite = Tramite::where('id',$id)->first()->tipo;
        
        $data = [
            "tramite" => $tramite,
            "mensaje" => $request->mensaje,
            "asunto"  => $request->asunto,
            "fecha"   => $request->fecha,
            "hora"    => $request->hora,
        ];

        if ($request->hasFile('file'))
            $data["file"] = $request->file('file');

        try {
            \Mail::to($user)->send(new EmailEgresados($data));

            $cita = new Cita();
            $cita->tramite_id = $id;
            $cita->descripcion = $request->mensaje;
            $cita->fecha = $request->fecha;
            $cita->hora  = $request->hora;
            $cita->asunto = $request->asunto;
            $cita->save();

        } catch (\Throwable $th) {
            \DB::table('emails_not_sends')->insert([
                'destino' => $user,
                'mensaje' => $request->mensaje,
                'tramite_id' => $id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'asunto' => $request->asunto
            ]);
        }
        return redirect()->back()->with('status','Un email ha sido enviado al correo');
    }

    public function deleteCita($id)
    {
        $cita = Cita::where('id',$id);
        $cita->delete();
        return redirect()->back();
    }
}