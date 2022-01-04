<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserPerfil;

class Acessos extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function loadUsers($id=null) {
        $param["user"] = User::Find($id);
        $param["users"] = User::All()->sortBy('name');
        $param["hasUser"] = !is_Null($id);
        if($param["hasUser"] == false){
            $param["user"] = new User();
        }

        $param["user"]->userPerfil = $param["user"]->userPerfil()->first();
        if(!is_Null($param["user"]->userPerfil)){
            $param["userCria"] = $param["user"]->userPerfil->userCria()->first();
            $param["userAltera"] = $param["user"]->userPerfil->userAltera()->first();            
        }else{
            $param["user"]->userPerfil = new UserPerfil();
            $param["userCria"] = new UserPerfil();
            $param["userAltera"] =  new UserPerfil();
        }

        $param["user"]->isBloq = false;
        if($param["user"]->userPerfil){
            try {
                $param["user"]->isBloq = str_contains($param["user"]->userPerfil->acessos, 'bloq');
            } catch (\Throwable $th) {
                $param["user"]->isBloq = false;
            }
            
        }
        $param["bloqAction"] = ($param["user"]->isBloq) ? 'acessos/desbloquear' : 'acessos/bloquear';
        
        $param["acessosList"] = array('Coordenador', 'Ministerios', 'Pascom');
        return $param;
    }
    
    public function index(){
        Security('acessos');

        $param = $this->loadUsers();
        $param["readOnly"]=true;
        $param["formAction"]=url("acessos/update");
        return view('acessos/acessos', $param);  
    }

    public function novo(){
        Security('acessos');

        $param = $this->loadUsers();
        $param["readOnly"]=false;
        $param["formAction"]=url("acessos/insert");
        return view('acessos/acessos', $param);  
    }

    public function edit($id){
        Security('acessos');

        if($id == 1){
            return view('acessos/denied');
        }

        $param = $this->loadUsers($id);
        $param["readOnly"]=true;
        $param["formAction"]=url("acessos/update");
        return view('acessos/acessos', $param);  
    }

    public function insert(Request $request){
        Security('acessos');

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::Find($request->id);

        if (isset($request->name)){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $userPerfil = new UserPerfil;
            $userPerfil->userId = $user->id;
            $userPerfil->acessos = strtolower($request->acessos);
            $userPerfil->created_by = auth()->user()->id;
            $userPerfil->updated_by = auth()->user()->id;
            $userPerfil->save();

            return redirect()->action([Acessos::class, 'index']);

        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Novo Usuário";
            return $this->openView('acessos.acessos', $param);
        }
    }

    public function update(Request $request){
        Security('acessos');

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $user = User::Find($request->id);

        if ($request){
            $user->name = $request->name;
            if($request->password != ''){
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $userPerfil = UserPerfil::Where('userId', '=', $user->id)->first();
            if(!$userPerfil->first()){
                $userPerfil = new UserPerfil;
                $userPerfil->userId = $user->id;
                $userPerfil->created_by = auth()->user()->id;
            }
            $userPerfil->acessos = strtolower($request->acessos);
            $userPerfil->updated_by = auth()->user()->id;
            $userPerfil->save();

            return redirect()->action([Acessos::class, 'index']);

        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Alterar Usuário";
            return $this->openView('acessos.acessos', $param);
        }
    }

    public function bloquear(Request $request){
        Security('acessos');

        $validated = $request->validate([
            'id' => 'required',
        ]);

        if ($request){
            $user = User::Find($request->id);

            $userPerfil = UserPerfil::Where('userId', '=', $user->id)->first();
            if(!$userPerfil->first()){
                $userPerfil = new UserPerfil;
                $userPerfil->userId = $user->id;
                $userPerfil->created_by = auth()->user()->id;
            }
            $acessos = strtolower($request->acessos);
            if ($acessos == ""){
                $split = Array();
            }else{
                $split = explode(';', $acessos);
            }
            
            array_push($split, 'bloq');

            $userPerfil->acessos = implode(';', (array)$split);
            $userPerfil->updated_by = auth()->user()->id;
            $userPerfil->save();

            return redirect()->action([Acessos::class, 'edit'], ['id' => $user->id]);
        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Bloquear usuário";
            return $this->openView('acessos.acessos', $param);  
        }
    }

    public function desbloquear(Request $request){
        Security('acessos');

        $validated = $request->validate([
            'id' => 'required',
        ]);

        if ($request){
            $user = User::Find($request->id);

            $userPerfil = UserPerfil::Where('userId', '=', $user->id)->first();
            
            $acessos = strtolower($request->acessos);
            $split = explode(';', $acessos);
            $split = array_diff( $split, ['bloq'] );
            
            $userPerfil->acessos = implode(';', (array)$split);
            $userPerfil->updated_by = auth()->user()->id;
            $userPerfil->save();

            return redirect()->action([Acessos::class, 'edit'], ['id' => $user->id]);
        }else{
            $param["errorMsg"] = "Operação inválida";
            $param["title"] = "Bloquear usuário";
            return $this->openView('acessos.acessos', $param);  
        }
    }

    public function denied(){
        return view('acessos/denied');
    }
}