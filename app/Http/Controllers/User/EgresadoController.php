<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Cita;
use App\Models\Tramite;
use App\Models\Egresado;
use App\Models\ListaTramite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EgresadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('api',['except' => ['unauthorized']]);
        $this->guard="api";
    }

    public function unauthorized()
    {
        return response()->json(Response::HTTP_UNAUTHORIZED);
    }

    public function getFormulario($id){
        if (!User::where('id',$id)->where('is_admin',0)->first()){
            return response()->json(['Usuario no encontrado'],402);
        } 
        $formulario = Egresado::where('user_id',$id)->first();
        if ($formulario)
            return response()->json(['data' => $formulario]);
        else 
            return response()->json(['Formulario no registrado'],401);
    }

    public function setFormulario(Request $request)
    {
        if (!User::where('id',$request->id)->where('is_admin',0)->first()) 
            return response()->json(['Usuario no encontrado'],401);

        $id = Egresado::where('user_id',$request->id)->first();

        if(!$id){
            $user = new Egresado();
            $user->user_id = $request->id;
            $user->name = $request->name;
            $user->apellido1 = $request->apellido1;
            $user->apellido2 = $request->apellido2;
            $user->noControl = $request->noControl;
            $user->movil = $request->movil;
            $user->telefono_casa = $request->telefono_casa;
            $user->email_alternativo = $request->email_alternativo;
            $user->carrera = $request->carrera;
            $user->fechaIngreso = $request->fechaInicio;
            $user->fechaEgreso = $request->fechaEgreso;
            $user->save();
            return response()->json(['Registrado con éxito']);
        }
        else return response()->json(["Formulario registrado"],401);
    }

    public function updateFormulario(Request $request,$id)
    {
        if (!User::where('id',$request->id)->where('is_admin',0)->first()) 
            return response()->json(['Usuario no encontrado'],401);
        
        $formulario = Egresado::where('user_id',$request->id)->first();
        if($formulario){
            $formulario->name = $request->name;
            $formulario->apellido1 = $request->apellido1;
            $formulario->apellido2 = $request->apellido2;
            $formulario->noControl = $request->noControl;
            $formulario->movil = $request->movil;
            $formulario->telefono_casa = $request->telefono_casa;
            $formulario->email_alternativo = $request->email_alternativo;
            $formulario->carrera = $request->carrera;
            $formulario->fechaIngreso = $request->fechaInicio;
            $formulario->fechaEgreso = $request->fechaEgreso;
            $formulario->save();

            return response()->json(['Formulario actualizado satisfactoriamente']);
        }
        else return response()->json(['Formulario no encontrado'],401);
    }

    public function getTramites($id)
    {
        $egresado_id = Egresado::where('user_id',$id)->first();
        if ($egresado_id) $egresado_id = $egresado_id->id;
        else return response()->json(['Egresado no encontrado'],401);
        
        $tramite = Tramite::select('tipo')->where('egresado_id',$egresado_id)->get();
        $tramites = ListaTramite::select('name')->whereNotIn('name',$tramite)->get();
        return response()->json([
            'data' => $tramites
        ]);
    }

    public function setTramite(Request $request)
    {   
        if (!User::where('id',$request->id)->where('is_admin',0)->first()) 
            return response()->json(['Usuario no encontrado'],401);
        
        $egresado_id = Egresado::where('user_id',$request->id)->first();
        if ($egresado_id) $egresado_id = $egresado_id->id;
        else return response()->json(['Egresado no encontrado'],401);
        
        $setTramite = Tramite::where('egresado_id',$egresado_id)->where('tipo',$request->tipo)->first();
        if($setTramite) return response()->json(['Trámite en proceso'],401);
        else{
            $tramite = new Tramite();
            $tramite->egresado_id = $egresado_id;
            $tramite->tipo = $request->tipo;
            $tramite->finalizado = 0;
            $tramite->save();
            return response()->json(['tramite' => $tramite]);
        }
    }

    public function getCitas($id)
    {
        $egresado_id = Egresado::where('user_id',$id)->first();
        if ($egresado_id) $egresado_id = $egresado_id->id;
        else return response()->json(['Egresado no encontrado'],401);
        $citas = Cita::join('tramites','citas.tramite_id','=','tramites.id')->where('tramites.egresado_id',$egresado_id)->get();
        return response()->json([
            'data' => $citas
        ]);
    }
}