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
			#tblRepertorios tr td:last-child {
				white-space: nowrap;
				width: 1px;
			}
			#tblRepertorios tr td:last-child {
				text-align: right;
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
    		<h2>Pesquisa de músicas</h2>
    		<br>
    		<form id="formHeader" class="row g-3 col-12 col-sm-12">
    
    			<div class="col-12 col-sm-4 col-md-2">
    				<div>
    					<label for="tipoMus" class="form-label">Tipo de categoria:</label>
    					<select id="tipoMus" class="form-select" name="tipoMus"
    						aria-label="Selecione o tipo">
    						<option value="" selected>Selecione...</option>
    						<option value="Missa">Missa</option>
    						<option value="Geral">Geral</option>
    					</select>
    				</div>
    			</div>

				<div class="col-12 col-sm-4 col-md-2">
    				<div>
    					<label for="categMus" class="form-label">Categoria da música:</label>
    					<select id="categMus" class="form-select" name="categMus"
    						aria-label="Selecione o tipo">
    						<option value="" selected>Selecione...</option>
    						@foreach ($categoria as $value)
							<option class="opt{{$value['tipo']}}" value="{{$value['categoria']}}">{{$value['categoria']}}</option>
                            @endforeach
    					</select>
    				</div>
    			</div>

				<div class="col-12 col-sm-4 col-md-2">
    				<div>
    					<label for="autorMus" class="form-label">Autores de música:</label>
    					<select id="autorMus" class="form-select" name="autorMus"
    						aria-label="Selecione o tipo">
    						<option value="" selected>Selecione...</option>
    						@foreach ($autores as $value)
							<option value="{{$value['autor']}}">{{$value['autor']}}</option>
                            @endforeach
    					</select>
    				</div>
    			</div>

				<div class="col-12 col-sm-12 col-md-6">
    				<div>
    					<label for="searchMus" class="form-label">Localizar por nome da música:</label>
    					<input type="text" id="searchMus" class="form-control" name="search" placeholder="Pesquisar por nome ou letra"/>
    				</div>
    			</div>
    
    			<hr>
    		</form>
			@if ($editing)
			<a class="btn btn-primary" href="{{url("musicas/nova")}}" role="button">Nova música</a>
			@endif
			<table id="tblMusicas" class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col" class="col-1" style="width: 10px; vertical-align: middle;">#</th>
						<th scope="col" class="col-3">Música<div style="font-size: 13px;">Autor</div></th>
						<th scope="col" class="col-3">Categorias</th>
						<th scope="col" style="width: 0.1%;">Ações</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($musicas as $musica)
					<tr class="rowId{{$musica->id}}" data-musica="{{$musica->nome}}" data-autor="{{$musica->autor}}" data-tipo="{{implode(",", $musica->tipos)}}" data-categ="{{implode(",", $musica->categorias)}}">
						<th scope="row" class="colId rowRef">{{$musica->id}}</th>
						<td class="col tdOverflow" data-field="musica" data-toggle="tooltip" data-placement="top" title="{{$musica->nome}}">
							{{$musica->nome}}
							<div data-toggle="tooltip" data-placement="top" title="{{$musica->autor}}" style="font-size: 13px;">
								{{$musica->autor}}
							</div>
						</td>
						<td class="col-3">
							@foreach ($musica["categorias"] as $categoria)
							<span class="badge bg-secondary label">{{$categoria}}</span>
							@endforeach
						</td>
						<td class="col-1 last-col">
							<a href="{{url("musicas/edit/$musica->id")}}"><i data-feather="edit"></i></a>
							@if ($isAdmin)
								<a href="#" class="linkDel" data-id="{{$musica->id}}"><i data-feather="trash-2"></i></a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
    	</div>
@endsection

@section('javaScript')
			//$('[data-toggle="tooltip"]').tooltip();
			

			$(".linkDel").on( "click", function(e) {
				if (!confirm("Tem certeza que deseja excluir esta música?\nEsta ação é irreversível!")){
					return false;
				}
				
				var musicaId = $(e.currentTarget).data('id');
				var data = {
					'_token': $('meta[name=csrf-token]').attr('content'),
					id: musicaId,
				};

				var jqxhr = $.post( "{{url("musicas/delete")}}", data, function(response) {
					$(".rowId" + musicaId).remove();
				})
				.done(function(response) {
					alert( "Música Excluída com sucesso" );
				})
				.fail(function(response) {
					var msg = response.responseJSON.message;
					alert("Ohh não, algo deu errado! A música não pôde ser excluída!\n" + msg);
				});
			});

        	$( "#tipoMus" ).on( "change", function(e) {
        		if ($("#tipoMus").val() == "Missa"){
        			$(".optMissa" ).show();
        			$(".optGeral" ).hide();
        		}else if ($("#tipoMus").val() == "Geral"){
        			$(".optMissa" ).hide();
        			$(".optGeral" ).show();
        		}else{
        			$(".optMissa" ).show();
        			$(".optGeral" ).show();
        		}

				var nth = "#tblMusicas tbody tr";
				var valor = $(this).val();
				$("#tblMusicas tbody tr").show();

				$(nth).each(function(){
					if(!$(this).data("tipo").includes(valor)){
						$(this).hide();
					}
				});
        	});

			$( "#categMus" ).on( "change", function(e) {
				var nth = "#tblMusicas tbody tr";
				var valor = $(this).val();
				$("#tblMusicas tbody tr").show();

				$(nth).each(function(){
					if(!$(this).data("categ").includes(valor)){
						$(this).hide();
					}
				});
        	});

			$( "#autorMus" ).on( "change", function(e) {
				var nth = "#tblMusicas tbody tr";
				var valor = $(this).val();
				$("#tblMusicas tbody tr").show();

				$(nth).each(function(){
					if(!$(this).data("autor").includes(valor)){
						$(this).hide();
					}
				});
        	});

			$("#searchMus").keyup(function(){       
				var nth = "#tblMusicas tbody tr";
				var valor = $(this).val().toUpperCase();
				$("#tblMusicas tbody tr").show();

				$(nth).each(function(){
					if(!$(this).data("musica").toUpperCase().includes(valor)){
						$(this).hide();
					}
				});
			});
		 
			$("#searchMus").blur(function(){
				$(this).val("");
			});
@endsection