<?php

namespace App\Http\Controllers\Admin\Citas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailsNotSends;
use App\Http\Controllers\Admin\Filter;
use App\Models\Cita;
use App\Mail\EmailEgresados;
use App\Models\Tramite;

class CitasController extends Controller
{
    public function getCitasNoEnviadas()
    {
        $citasNoEnviadas = EmailsNoTSends::all();
        
        return view('citas.citasNoEnviadas',[
            'citas' => $citasNoEnviadas
        ]);
    }

    public function sendMailsRestantes(Request $request)
    {   
        
        $selected = $request->only('option');
        
        $filterEmails = new Filter();

        if($selected){
            $citasSelected = $filterEmails->getEmailsNoEnviados($selected);
        }
        else{
            $citasSelected = EmailsNotSends::all();   
        }
        
        foreach($citasSelected as $cita){
            $tramite = Tramite::where('id',$cita->tramite_id)->first()->tipo;

            $data = [
                "mensaje" => $cita->mensaje,
                "asunto"  => $cita->asunto,
                "fecha"   => $cita->fecha,
                "hora"    => $cita->hora,
                "tramite" => $tramite
            ];

            try {
                \Mail::to($cita->destino)->send(new EmailEgresados($data));
                
                $newCita = new Cita();
                $newCita->tramite_id = $cita->tramite_id;
                $newCita->descripcion = $cita->mensaje;
                $newCita->fecha = $cita->fecha;
                $newCita->hora = $cita->hora;
                $newCita->asunto = $cita->asunto;
                $newCita->save();

                $cita = EmailsNotSends::where('id',$cita->id);
                $cita->delete();

            } catch (\Throwable $th) {
                return $th;
            }
        }
        return redirect()->back()->with('status','Se han enviado los emails seleccionados');
    }
}
