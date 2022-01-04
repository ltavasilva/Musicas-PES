@extends('layouts.master')

@section('title', "$title")

@section('customHead')
        <style>
            .btn-group{
                margin-right: 5px;
                margin-bottom: 5px;
            }
            .btn-xs{padding: 0.05rem 0.2rem; font-size: 0.675rem;}
            #categoriasSel{margin-bottom: 15px; min-height: 38px;}
            .listResultVaga{height: 201px;}
            .grp{display: -webkit-inline-box;}
            .grp button{margin-left: 10px;}
            .listMembros{max-height: 250px;}
            .pull-right{float: right;}
        </style>
@endsection

@section('content')
		<div class="container">
            <a href="{{url("ministerios")}}" class="btn btn-secondary btn-sm">Lista dos ministérios </a>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    		<form id="formMinisterio" class="row g-3 col-12 col-sm-12" method="POST" action="{{url($formAction)}}">
            @csrf

                <input type="hidden" id="ministerioId" name="id" value="{{$ministerio->id}}">
                <input type="hidden" id="ministerioMembrosJson" name="membrosJson" value="{{old("membrosJson", $ministerio->membrosJson)}}">
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                    <label for="ministerioNome" class="form-label">Nome do ministério</label> 
                    <input type="text" id="ministerioNome" class="form-control" name="nome" placeholder="Nome do ministério" 
                    value="{{ ($errors->any()) ? old('nome') : $ministerio->nome }}">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                    <label for="ministerioCoordenador" class="form-label">Coordenador do ministério</label> 
                    <select id="ministerioCoordenador" class="form-select" style="margin-right: 5px;" name="coordenador" aria-label="Selecione o coordenador do ministério">
                        <option value="" selected>Selecione...</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}"{{($user->id == $ministerio->coordenador ? ' selected' : '')}}>{{$user['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                    <label for="ministerioCoresponsavel" class="form-label">Coresponsável do ministério</label> 
                    <select id="ministerioCoresponsavel" class="form-select" style="margin-right: 5px;" name="corresponsavel" aria-label="Selecione o corresponsável do ministério">
                        <option value="" selected>Selecione...</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}"{{($user->id == $ministerio->corresponsavel ? ' selected' : '')}}>{{$user['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1 col-xxl-1" style="padding-top: 38px;">
                    <input class="form-check-input" type="checkbox" value="{{$ministerio->ativo}}"{{($ministerio->ativo == 1 ? ' checked' : '')}} name="ativo" id="chAtivo">
                    <label class="form-check-label" for="chAtivo">Ativo</label>
                </div>
                @if($isAdmin)
                <div class="col-2 col-sm-2 col-md-2 col-lg-1 col-xl-1 col-xxl-1" style="padding-top: 38px;">
                    <button id="btnMembros" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMembros">Membros</button>
                </div>
                @endif
                @if ($submit || $editing) 
                <hr>
                @endif
                @if ($submit)
                <div class="col">
                    <button id="btnSubmit" type="submit" class="btn btn-primary">Salvar</button>
                @endif
            </form>
            
            <!-- Modal -->
            <div class="modal fade" id="modalMembros" tabindex="-1"
                aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Lista dos membros</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row">

                                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                                    <label for="users" class="form-label">Selecione o novo membro:</label> 
                                    <div class="grp">
                                        <select id="users" class="form-select" name="users" aria-label="Selecione um membro">
                                            <option value="" selected>Selecione...</option>
                                            @foreach ($ministerio->naoMembros as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        <button id="btnAdd" type="button" class="btn btn-primary">Add <i data-feather="plus-square" class="feather16"></i></button>
                                    </div>
                                </div>
                            </form>

                            <hr>

                            <div class="resultVaga">
                                <div class="label">
                                    Membros
                                </div>
                                <div class="list-group overflow-auto listMembros">
                                    @foreach ($ministerio->membros as $user)
                                    <div class="list-group-item itemMembro{{$user->id}}">{{$user->name}} 
                                        <a href="#" class="btnDelMembro delMembro{{$user->id}}" data-id="{{$user->id}}" data-nome="{{$user->name}}"><span class="pull-right"><i data-feather="x-square" class="feather16"></i></span></a>
                                    </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button id="btnSalvarMembro" type="button" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
@endsection

@section('javaScript')

            var isError = {!!($errors->any()) ? 'true' : 'false' !!};
            var mode = '{{$mode}}';
            function hasCoordenador(user) {
                return user.id === $('#ministerioCoordenador').val();
            }

            function hasCoresponsavel(user) {
                return user.id === $('#ministerioCoresponsavel').val();
            }
            
            function setMembrosObj(){
                var json = [];
                $(".listMembros a").each(function(i, elm) {
                    var id = $(elm).attr("data-id");

                    var obj = {id: id};
                    json.push(obj);
                });

                if(json.find(hasCoordenador) === undefined){
                    var id = $('#ministerioCoordenador').val();
                    json.push({id: id});
                }

                if(json.find(hasCoresponsavel) === undefined){
                    var id = $('#ministerioCoresponsavel').val();
                    json.push({id: id});
                }
                
                if(!isError){
                    $("#ministerioMembrosJson").val(JSON.stringify(json));
                    isError = false;
                }
            }

            function delMembro(e){
                var elm = $(e.currentTarget);
                var id = elm.data("id");
                var nome = elm.data("nome");
                $( ".itemMembro" + id ).remove();

                $('#users').append($('<option>', {
                    value: id,
                    text: nome
                }));
                
            }

            function addListMembros(id, nome){
                if(id != ""){
                    item = '<div class="list-group-item itemMembro' + id + '">' + nome;
                    item += '<a href="#" class="btnDelMembro membro delMembro"' + id + ' data-id="' + id + '" data-nome="' + nome + '"><span class="pull-right"><i data-feather="x-square" class="feather16"></i></span></a></div>';

                    $('.listMembros').append( item );

                    $(".btnDelMembro").unbind("click");
                    $('.btnDelMembro').bind('click', function(e){
                        delMembro(e);
                    }); 

                    $("#users option[value='"+id+"']").remove();
                    
                    feather.replace();
                }
            }

            function addAdminOnNew(){
                var coordId = $('#ministerioCoordenador').val();
                var coordNome = $('#ministerioCoordenador option:selected').text();
                $( ".itemMembro" + coordId ).remove();
                
                var corespId = $('#ministerioCoresponsavel').val();
                var corespNome = $('#ministerioCoresponsavel option:selected').text();
                $( ".itemMembro" + corespId ).remove();

                addListMembros(coordId, coordNome);
                addListMembros(corespId, corespNome);
            }
@if($mode == "new")
            $('#modalMembros').on('show.bs.modal', function (event) {
                addAdminOnNew();
            });
@endif

            $('#chAtivo').on('change', function(){
                if(this.checked)
                {
                    $('#chAtivo').val("1");
                }else{
                    $('#chAtivo').val("0");
                }
            });

            $('#ministerioCoordenador').on('change', function(){
                setMembrosObj()
            });

            $('#ministerioCoresponsavel').on('change', function(){
                setMembrosObj()
            });

            $('#btnAdd').on('click', function(e){
                var id = $('#users').val();
                var nome = $('#users option:selected').text();

                addListMembros(id, nome);
            });

            $('.btnDelMembro').on('click', function(e){
                delMembro(e);
            });

            $('#btnSalvarMembro').on('click', function(e){
                setMembrosObj();
                $('#modalMembros').modal('hide');
            });
@endsection