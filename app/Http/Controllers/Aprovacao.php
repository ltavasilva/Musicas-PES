<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Repertorio;
use App\Models\RepertorioMusica;
use Carbon\Carbon;

class Aprovacao extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function loadCore($id=null) {
        $param["title"] = "Aprovação de repertorios de Missa";
        $repertorios = Repertorio::whereIn('status', array(1, 4))->where('idMinisterio', '!=', 0)->get();
        if($repertorios){
            $repertorios->motivo = "";
            foreach ($repertorios as &$repertorio) {
                $repertorio["ministerio"] = $repertorio->ministerio()->first();
                $repertorio["musicas"] = $repertorio->musicas()->get();
                foreach ($repertorio["musicas"] as &$musica) {
                    $musica->info=RepertorioMusica::where('idRepertorio', $repertorio->id)
                        ->where('idMusica', $musica->id)->first();
                    $musica->categoria = $musica->info->categoria()->first();
                    $musica->motivo = $musica->info->motivo;
                }
                $repertorio["aging"] = timeAgo($repertorio->updated_at);
            }
        }
        $param["repertorios"] = $repertorios;
        return $param;
    }

    public function index(){
        Security('coordenador');

        $param = $this->loadCore();

        $param["formAction"]=url("aprovacao/update");
        return view('aprovacao/aprovar', $param);  
    }

    public function update(Request $request){
        Security('coordenador');

        $jsonText = $request->musicas;
        $decodedText = html_entity_decode($jsonText);
        $musicas = json_decode($decodedText);
        
        $aprov = true;
        if(isset($musicas)){
            foreach ($musicas as $musica) {
                $repertorioMusica = RepertorioMusica::where('idRepertorio', $request->id)->where('idMusica', $musica->musica)->first();
                if($repertorioMusica){
                    if($musica->motivo != ""){
                        $repertorioMusica->motivo = $musica->motivo;
                        $repertorioMusica->aprovado = 3;
                        $aprov = false;
                    }else{
                        $repertorioMusica->aprovado = 2;
                    }
                    $repertorioMusica->save();
                }
            }
        }

        $repertorio = Repertorio::Find($request->id);

        if ($aprov == true) {
            $repertorio->status = 2;
        }else{
            $repertorio->status = 3;
        }

        if($request->motivo != ''){
            $repertorio->status = 3;
            $repertorio->motivo = $request->motivo;
        }elseif ($aprov == false) {
            $repertorio->motivo = "Verificar o motivo nas músicas reprovadas";
        }

        $repertorio->approved_by = auth()->user()->id;
        $repertorio->approved_at = Carbon::now();
        $repertorio->save();
    }
}