<?php

use App\Models\UserPerfil;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

function str_Contains_InArray($text, $array){
    $return = false;
    $teste = "";
    if(is_Array($array)){
        foreach ($array as $token) {
            if (str_contains($text, $token) !== FALSE) {
                return true;                
            }
        }
    }else{
        throw "O Parametro informado não é um array";
    }
    return $return;
}

function menuArray(){ 
    $user = Auth::user(); 

    $isAdmin = false;
    $acessos = array();

    if($user){
        $acessos[] = "repertorios";
        $acessos[] = "musicas";
        $acessosAdm = array('admin', 'coordenador');
        $perfil = UserPerfil::where('userId', $user->id)->get()->first();
        if($perfil){
            $isAdmin = str_Contains_InArray($perfil->acessos, $acessosAdm);
            $acessos = array_merge($acessos, explode(";", $perfil->acessos));
        }
    }

    $menu = Menu::all()->sortBy('sequencia');
    $menuDefault = Array();
    foreach ($menu as $item) {
        $menuDefault[$item->menu] = Array($item->descricao, $item->comentario);
    }

    $menuAccess = array();
    if (!$isAdmin) {
        foreach ($acessos as $acesso) {
            if(isset($menuDefault[$acesso])){
                $menuAccess[$acesso] = $menuDefault[$acesso];
            }
        }
    }else{
        $menuAccess = $menuDefault;
    }
    return $menuAccess;
}

function setMenu(){ 
    $menuAccess = menuArray();

    $controller = strtolower(Route::getCurrentRoute()->uri);

    $menu = "";
    foreach ($menuAccess as $item=>$menuItem) {
        $activeHome = ($controller == $item ? ' active' : '');
        $menu .= "<li class='nav-item nav-item-min'>
        <a class='nav-link{$activeHome}' href='".url($item)."'>{$menuItem[0]}</a>
        </li>";
    }
    echo $menu;
}

function Filter($Object, $field, $value){
    $ret = Array();
    foreach($Object as $item){
        if(data_get($item, $field) == $value){
            $ret[] = $item;
        }
    }
    return $ret;
}

function checkContentAccess($Object, $field, $value){
    $hasAccess = Filter($Object, $field, $value);

    if(Count($hasAccess) == 0){
        return redirect()->route('denied')->send();
    }
}

function isBloqued(){ 
    $user = Auth::user(); 
    if(isset($user->id)){
        $perfil = UserPerfil::where('userId', $user->id)->get()->first();

        if ($perfil && str_contains($perfil->acessos, 'bloq')) {
            return redirect()->route('denied')->send();
        }
    }

    return false;
}

function Security($perfilCheck){ 
    $result = false;
    if(isBloqued()){
        return redirect()->route('denied')->send();
    }

    $user = Auth::user(); 
    if(isset($user->id)){
        $perfil = UserPerfil::where('userId', $user->id)->get()->first();

        $acessosAdm = array('admin', 'coordenador', $perfilCheck);
        if ($perfil && str_Contains_InArray($perfil->acessos, $acessosAdm)) {
            $result = true;
        }
    }else{
        $result = false;
    }
    if($result == false){
        return redirect()->route('denied')->send();
    }else{
        return $result;
    }
}

function isCoordenador(){ 
    $result = false;
    if(isBloqued()){
        return redirect()->route('denied')->send();
    }

    $user = Auth::user(); 
    if(isset($user->id)){
        $perfil = UserPerfil::where('userId', $user->id)->get()->first();
        
        $acessosAdm = array('admin', 'coordenador');
        if ($perfil && str_Contains_InArray($perfil->acessos, $acessosAdm)) {
            $result = true;
        }
    }else{
        $result = false;
    }
    return $result;
}

function timeAgo($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}

function dateInfo($data) {
    setlocale(LC_TIME, 'ptb');
    $dataInfo = Array();
    $dataInfo['date'] = $data->format('Y-m-d');
    $dataInfo['dayOfWeek'] = $data->dayOfWeek;
    $dataInfo['weekOfMonth'] = $data->weekOfMonth;
    $dataInfo['firstOfMonth'] = $data->format('Y-m-01');
    $dataInfo['weekOfYear'] = $data->format('W');
    $dataInfo['diaSemanaStr'] = $data->formatLocalized('%A');

    return $dataInfo;
    //return $data->format('Y-m-d') . " = $weekOfMonth -> ".$data->formatLocalized('%A')." - ".$data->dayOfWeek." <br>";
}

function dataFormat($date) {
    setlocale(LC_TIME, 'ptb');
    $data = Carbon::parse($date);

    return $data->format('d/m/Y');
}