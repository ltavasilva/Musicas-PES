@extends('layouts.master')

@section('title', "$title")

@section('customHead')
		<meta name="csrf-token" content="{{ Session::token() }}">
		<style>
			.nomeMusica{
				width: 100%;
			}
			.musicaInfo{
				margin-top: 7px;
			}
		</style>
@endsection

@section('content')
		<div class="container">
    		<h2>Sistema de gerenciamento de repertórios da PES</h2>
    		<br>
    		<form id="formHeader" class="row g-3 col-12 col-sm-12">
    
    			<div class="col-12 col-sm-12 col-md-3">
    				<label for="ministerio" class="form-label">Ministério de música:</label> 
					<input type="text" class="form-control" id="ministerio" name="ministerio" readonly value="{{$ministerio->nome}}">
    			</div>

				<div class="col-12 col-sm-6 col-md-3">
    				<label for="descricao" class="form-label">Descrição:</label> 
					<input type="text" class="form-control" id="descricao" name="descricao" readonly value="{{$repertorio->descricao}}">
    			</div>

				<div class="col-12 col-sm-6 col-md-2">
    				<div>
    					<label for="tipoRep" class="form-label">Tipo de repertório:</label>
    					<select id="tipoRep" class="form-select" name="tipoRep" disabled tabindex="-1" aria-disabled="true"
    						aria-label="Selecione o tipo">
    						<option value="">Selecione...</option>
    						<option value="Missa"{{ ($repertorio->tipo == "Missa") ? ' selected' : '' }}>Missa</option>
    						<option value="Geral"{{ ($repertorio->tipo == "Geral") ? ' selected' : '' }}>Geral</option>
    					</select>
    				</div>
    			</div>
    
    			<div class="col-12 col-sm-6 col-md-2">
    				<label for="dataEvento" class="form-label">Data do evento:</label> 
					<input type="date" class="form-control" id="dataEvento" name="dataEvento" readonly value="{{$repertorio->dataEventoDate}}">
    			</div>

				<div class="col-12 col-sm-6 col-md-2">
    				<label for="horaEvento" class="form-label">Hora do evento:</label> 
					<input type="time" class="form-control" id="horaEvento" name="horaEvento" readonly value="{{$repertorio->DataEventoTime}}">
    			</div>
			</form>
			<hr>

			<!-- Modal Letra -->
			<div class="modal fade" id="LetraModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
				<div class="modal-dialog modal-fullscreen">
					<div class="modal-content">
						<div class="modal-header">
							<div class="block">
								<h5 class="modal-title" id="modalLabel"><div class="labelMusica">Nome da música</div></h5>
								<div class="labelAutor">Autor da música</div> 
							</div>
							
							<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Letra</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Slides</button>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<form id="formHeader" class="row">
										<div class="col-12">
											<textarea id="musicaLetra" class="form-control" name="letra" 
												placeholder="Letra da música" rows="20"></textarea>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
									<div id="slidesHtml"></div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<table id="tblMusicas" class="table table-striped table-hover">
				<thead>
					<tr>
						<th scope="col" style="width: 10px;">#</th>
						<th scope="col">Música</th>
					</tr>
				</thead>
				<tbody id="repertorioItem">
					@foreach ($repertorioMusicas as $musica)
					<tr data-id="{{$repertorio->id}}" data-sequencia="{{$musica->sequencia}}" data-musica={{$musica->idMusica}} data-aprovado="{{$musica->aprovado}}" data-categoria="{{$musica->idCategoria}}"
						data-categoriaStr="{{$musica->categoria}}" data-nome="{{$musica->nome}}" data-autor="{{$musica->autor}}">
						<th scope="row" class="rowRef">
							<p>{{$musica->sequencia}}</p>
						</th>
						<td>
							<div class="card">
								<div class="card-body">								
									<div class="row">
										
										<div class="col-12 col-sm-10 col-md-10">
											<h4 class="card-title">{{$musica->categoria}}</h4>
										</div>
										<div class="col-12 col-sm-2 col-md-2">
											<button type="button" aria-label="View" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#LetraModal" 
												data-musica="{{$musica->idMusica}}">
												<i data-feather="book-open"></i> ver a Letra
											</button>
										</div>
										<div class="col-12 col-sm-12 col-md-12 musicaInfo">
											<h5 class="card-subtitle text-muted item">
												{{$musica->autor." - ".$musica->nome}}
											</h5>
										</div>
									</div>
									
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
    	</div>
@endsection

@section('javaScript')
$('#LetraModal').on('show.bs.modal', function (event) {
	var elem = $(event.relatedTarget);
	var data = elem.data(); 
	var url = "{{url('musicas/letra')}}/"+data.musica;

	var jqxhr = $.get( url , null, function(response){})
		.done(function(response) {
			var musica = response.nome;
			var autor = response.autor;
			var letra = response.letra;
			var slides = response.slides;

			$('#LetraModal .labelMusica').html("Música: "+musica);
			$('#LetraModal .labelAutor').html("<small>Autor: "+autor+"</small>");
			$("#musicaLetra").val(letra);
			$("#slidesHtml").html(slides);
		})
		.fail(function(response) {
			var msg = response.responseJSON.message;
			alert("Ohh não, algo deu errado!\n" + msg);
			$('#LetraModal').modal('hide');
		});
});
@endsection