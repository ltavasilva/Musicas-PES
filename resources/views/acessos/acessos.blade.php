@extends('layouts.master')

@section('title', "Lista das músicas")

@section('customHead')
		<meta name="csrf-token" content="{{ Session::token() }}">
        <style>
			thead tr th{vertical-align: middle;}
            .tdOverflow{
                max-width: 100px;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
				direction: ltr;
            }
			#tblMusicas tr td:last-child {
				white-space: nowrap;
				width: 1px;
			}
			#tblMusicas tr td:last-child {
				text-align: right;
			}
			.last-col svg:last-child{
				margin-left: 6px;
			}
			.colId{width: 0.5%;}
			.label{font-weight: 100;line-height: 0.8;}
			.form-group{margin-bottom: 10px;}

			#listUser{height: 300px;}
            .overflow-y{overflow-y: auto;}
        </style>
@endsection

@section('content')
		<div class="container">
			<h2>Sistema de gerenciamento de repertórios da PES</h2>
    		<br>
			<div class="row">
				<div class="col-12 col-sm-12 col-md-6">
					<label for="ministerio" class="form-label">Pesquisar usuário</label> 
					<input type="text" class="form-control" id="findUser"placeholder="Informação do usuário">
				</div>
			<div>

			@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
            @endif

			<hr>
			<div class="row">
				<div class="col-4">
					<h3>Lista de usuários</h3>
				</div>
				<div class="col-3">
					<a id="btnNewUser" href="{{url('acessos/novo')}}" aria-label="Add" class="btn btn-primary btn-sm">
						<i data-feather="user-plus"></i> Novo Usuário
					</a>
				</div>
			</div>

			<form id="frmBloq" method="POST" action="{{url("$bloqAction")}}">
				@csrf
				<input type="hidden" id="frmId" name="id" value="{{$user->id}}">
				<input type="hidden" id="frmAcessos" name="acessos" value="{{$user->userPerfil->acessos}}">
			</form>

			<div class="row">
				<div class="col-12 col-sm-12 col-md-4">
					<div id="listUser" class="list-group overflow-y">
						@foreach ($users as $usu)
						<?php $data = $usu->name.$usu->email;
						if(isset($usu->ministerioCoord)){$data .= $usu->ministerioCoord->nome;}
						if(isset($usu->ministerioCorresp)){$data .= $usu->ministerioCorresp->nome;}
						?>
						<a href="{{url("acessos/edit/{$usu->id	}")}}" data-id="{{$usu->id}}"
							data-info="{{$data}}" 
							class="list-group-item list-group-item-action{{($usu->id == $user->id) ? ' active' : ''}}">{{$usu->name}}</a>
						@endforeach
					</div>
				</div>

				<div class="col-12 col-sm-12 col-md-8">
					<form id="frmPerfil" method="POST" action="{{$formAction}}">
						@csrf
						@if($readOnly)
						<div class="form-group row">
							<label for="inputId" class="col-sm-2 col-form-label">Id</label>
							<div class="col-12 col-sm-2 col-md-2">
								<input type="text" name="id" class="form-control" id="inputId" value="{{($user->id == '') ? 0 : $user->id}}" readonly>
							</div>
							<a href="#" id="btnBloq" class="btn btn-primary btn-sm col-sm-2">
								<i data-feather="shield{{($user->isBloq) ? '' : '-off'}}"></i> {{($user->isBloq) ? 'Desbloquear' : 'Bloquear'}}
							</a>
						</div>
						@endif
						<input type="hidden" id="acessos" name="acessos" value="{{old('acessos', (isset($user->userPerfil->acessos)) ? $user->userPerfil->acessos : '')}}">
						<div class="form-group row">
							<label for="inputNome" class="col-sm-2 col-form-label">Nome</label>
							<div class="col-12 col-sm-10 col-md-5">
								<input type="text" name="name" class="form-control" id="inputNome" placeholder="Nome do usuário" value="{{old('name', (isset($user->name)) ? $user->name : '')}}">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
							<div class="col-12 col-sm-10 col-md-5">
								<div class="input-group col-12 sm-10">
									<div class="input-group-prepend">
										<div class="input-group-text">@</div>
									</div>
									<input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="{{old('email', $user->email)}}" {{($readOnly) ? 'readonly' : ''}}>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword3" class="col-sm-2 col-form-label">Senha</label>
							<div class="col-12 col-sm-10 col-md-5">
								<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Senha">
							</div>
						</div>
						<fieldset class="form-group row">
							<legend class="col-form-label col-sm-2 pt-0">Acessos</legend>
							<div class="col-12 col-sm-10 col-md-5">
								<ul class="list-group">
									@foreach ($acessosList as $acesso)
									<li class="list-group-item">
										<input id="ch{{$acesso}}" class="checkbox" type="checkbox" data-valor={{$acesso}} {{(str_contains(old('acessos', (isset($user->userPerfil->acessos)) ? $user->userPerfil->acessos : ''), strtolower($acesso)) ? 'checked' : '')}}>
										<label class="form-check-label" for="ch{{$acesso}}">{{$acesso}}</label>
									</li>	
									@endforeach
								</ul>
							</div>
						</fieldset>
						@if(isset($user->userPerfil->created_at))
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Informações</label>
							<div class="col-10 col-md-8 row">
								<div class="row">
									<div class="form-group col-12 col-sm-6 col-md-4">
										<label for="created_at" class="col-form-label">Criado em</label>
										<div class="">
											<input type="text" class="form-control" id="created_at" value="{{($user->userPerfil->created_at == '') ? 0 : $user->userPerfil->created_at}}" readonly>
										</div>
									</div>

									<div class="form-group col-12 col-sm-6">
										<label for="created_by" class="col-form-label">Criado por</label>
										<div class="">
											<input type="text" class="form-control" id="created_by" value="{{($userCria->name == '') ? 0 : $userCria->name}}" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-sm-6 col-md-4">
										<label for="updated_at" class="col-form-label">Alterado em</label>
										<div class="">
											<input type="text" class="form-control" id="updated_at" value="{{($user->userPerfil->updated_at == '') ? 0 : $user->userPerfil->updated_at}}" readonly>
										</div>
									</div>

									<div class="form-group col-12 col-sm-6">
										<label for="updated_by" class="col-form-label">Alterado por</label>
										<div class="">
											<input type="text" class="form-control" id="updated_by" value="{{($userAltera->name == '') ? 0 : $userAltera->name}}" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endif
					
						<div class="form-group row">
							<div class="col-sm-10">
							<button type="submit" class="btn btn-primary">Salvar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
    	</div>
@endsection

@section('javaScript')
		function searchAPI(target, list) {
			var value = $(target).val().toLowerCase();
			$(list + " > a").each(function (i, elm) {
				$(this).toggle($(this).data("info").toLowerCase().indexOf(value) > -1)
			});
		}

		$("#findUser").on("keyup", function() {
			searchAPI(this,'#listUser');
		});

		$(".checkbox").on("change", function() {
			var valor="", sep="";
			$(".checkbox").each(function (i, elm) {
				if($(elm).is(":checked")){
					valor = valor + sep + $(elm).data("valor");
					sep=";"
				}
			});
			$("#acessos").val(valor);
		});

		$("#btnBloq").click(function(){
			if (confirm('Tem certeza que deseja {{($user->isBloq) ? 'desbloquear' : 'bloquear'}} este usuário?')) {
				$("#frmBloq").submit();
			}
		});
@endsection