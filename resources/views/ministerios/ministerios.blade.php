@extends('layouts.master')

@section('title', "$title")

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
			#tblministerios tr td:last-child {
				white-space: nowrap;
				width: 1px;
				text-align: center;
			}
			.last-col svg:last-child{
				margin-left: 6px;
			}
			.colId{width: 0.5%;}
			.label{font-weight: 100;line-height: 0.8;}
        </style>
@endsection

@section('content')
		<div class="container">
    		<h2>Pesquisa de ministérios</h2>
    		<br>
    		<form id="formHeader" class="row g-3 col-12 col-sm-12">

				<div class="col-12 col-sm-10">
    				<div>
    					<label for="searchMinist" class="form-label">Nome do ministério:</label>
    					<input type="text" id="searchMinist" class="form-control" name="search" placeholder="Pesquisar por nome do ministério"/>
    				</div>
    			</div>
				<div class="col-12 col-sm-2" style="padding-top: 38px;">
    				<div>
    					<input class="form-check-input" type="checkbox" id="chListInativo">
						<label class="form-check-label" for="chAtivo">Listar Inativos</label>
    				</div>
    			</div>
    
    			<hr>
    		</form>
			@if ($editing)
			<a class="btn btn-primary" href="{{url("ministerios/novo")}}" role="button">Novo ministério</a>
			@endif
			<table id="tblministerios" class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col" class="col-1" style="width: 10px; vertical-align: middle;">#</th>
						<th scope="col" class="col-3">Ministério</th>
						<th scope="col" class="col-3">Coordenador</th>
						<th scope="col" class="col-3">Corresponsável</th>
						<th scope="col" class="col-3">Ativo</th>
						<th scope="col" style="width: 0.1%;">Ações</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ministerios as $ministerio)
					@if($ministerio->listar)
					<tr class="rowId{{$ministerio->id}}{{($ministerio->ativo == "0" ? ' ocultar' : '')}}" data-ministerio="{{$ministerio->nome}}" data-ativo="{{($ministerio->ativo == 1 ? '1' : '0')}}">
						<th scope="row" class="colId rowRef">{{$ministerio->id}}</th>
						<td class="col tdOverflow" data-field="ministerio" data-toggle="tooltip" data-placement="top" title="{{$ministerio->nome}}">
							{{$ministerio->nome}}
							<div data-toggle="tooltip" data-placement="top" title="{{$ministerio->autor}}" style="font-size: 13px;">
								{{$ministerio->autor}}
							</div>
						</td>
						<td class="col-3">{{(isset($ministerio->coordenador->name) ? $ministerio->coordenador->name : "")}}</td>
						<td class="col-3">{{(isset($ministerio->corresponsavel->name) ? $ministerio->corresponsavel->name : "")}}</td>
						<td class="col-3">
							<input class="form-check-input" type="checkbox" disabled readonly value="{{$ministerio->ativo}}"{{($ministerio->ativo == 1 ? ' checked' : '')}} name="ativo" id="chAtivo">
							<label class="form-check-label" for="chAtivo">Ativo</label>
						</td>
						<td class="col-1 last-col">
							<a href="{{url("ministerios/edit/$ministerio->id")}}"><i data-feather="edit"></i></a>
							@if($ministerio->ativo == 1)
							<a href="#" class="linkDel" data-id="{{$ministerio->id}}"><i data-feather="trash-2"></i></a>
							@endif
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
    	</div>
@endsection

@section('javaScript')
			//$('[data-toggle="tooltip"]').tooltip();
			

			$(".linkDel").on( "click", function(e) {
				if (!confirm("Tem certeza que deseja desativar este ministério?")){
					return false;
				}
				
				var ministerioId = $(e.currentTarget).data('id');
				var data = {
					'_token': $('meta[name=csrf-token]').attr('content'),
					id: ministerioId,
				};

				var jqxhr = $.post( "{{url("ministerios/delete")}}", data, function(response) {
					$(".rowId" + ministerioId).remove();
				})
				.done(function(response) {
					alert( "Ministério desativado com sucesso!" );
					location.reload();
				})
				.fail(function(response) {
					var msg = response.responseJSON.message;
					alert("Ohh não, algo deu errado! O ministério não pôde ser desativado!\n" + msg);
				});
			});

			$("#searchMinist").keyup(function(){      
				var listInativos;
				if($("#chListInativo").prop( "checked", true )){
					listInativos = "1";
				}else{
					listInativos = "0";
				}
				var nth = "#tblministerios tbody tr";
				var valor = $(this).val().toUpperCase();
				$("#tblministerios tbody tr").removeClass("ocultar");

				$(nth).each(function(){
					if(!$(this).data("ministerio").toUpperCase().includes(valor)){
						$(this).addClass("ocultar");
					}
				});

				var listInativos = $("#chListInativo").prop( "checked" );
				hideInativos(listInativos);
			});

			function hideInativos(listInativos){

				if(listInativos){
					$("#tblministerios tbody tr").filter('[data-ativo="0"]').removeClass("ocultar");
				}else{
					$("#tblministerios tbody tr").filter('[data-ativo="0"]').addClass("ocultar");
				}
			}
		 
			$("#searchMinist").blur(function(){
				$(this).val("");
			});

			$("#chListInativo").on( "change", function(e) {
				var listInativos = $(this).prop( "checked");
				hideInativos(listInativos);
			});
@endsection