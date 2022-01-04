@extends('layouts.master')

@section('title', "Lista das músicas")

@section('customHead')
		<meta name="csrf-token" content="{{ Session::token() }}">
		<style>
			.justify-content-between small{
				padding-right: 10px;
				display: contents;
			}
			.list-group-item small{display: block;}
			.list-group-action{color: inherit; text-decoration: inherit; cursor: pointer;}
			.listAprovar{overflow-y: auto; height: 400px;}
			.tdAprovar{width: 270px; margin-top: -13px;}
			.aprovado{float: right; margin-right: 8px;}
			.flexAuto{flex: auto;}
			.flex{display: flex;}
			.chAprovar{
				margin-top: 15px;
			}
		</style>
@endsection

@section('content')
		<div class="container">
			<h2>Sistema de gerenciamento de repertórios da PES</h2>
			<h4>Aprovação de Repertórios de Missa</h4>
    		<br>

			<div class="row">
				<div class="col-12 col-sm-12 col-md-6 listAprovar">
					<div class="accordion" id="listaRepertorio">
						@if (Count($repertorios) > 0)
							@foreach ($repertorios as $repertorio)
							<div id="repertorioItem-{{$repertorio->id}}" class="accordion-item">
								<h2 class="accordion-header" id="heading{{$repertorio->id}}">
									<div class="list-group-item list-group-item-action {{$repertorio->getStatusCardAttribute()}} accordion-button collapsed">
										<div class="d-flex w-100 justify-content-between">
											<h5 class="mb-1 flex">{{$repertorio->descricao}} -&nbsp<small><i data-feather="{{$repertorio->statusIcon}}"></i>{{$repertorio->statusStr}}</small></h5>
											<small>{{$repertorio->aging}}</small>
										</div>
										<p class="mb-1">{{$repertorio->ministerio->nome}}</p>
										<div class="d-flex">
											<small class="flexAuto">{{$repertorio->dataEvento}}</small>
											@if ($repertorio->status == 1)
											<div style="margin-right: 10px;"><button id="btnReprovar" type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ReprovarModal" data-id="{{$repertorio->id}}" data-motivo="{{$repertorio->motivo}}">Reprovar</button></div>
											<div style="margin-right: 10px;"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#collapse{{$repertorio->id}}" aria-expanded="false" aria-controls="collapse{{$repertorio->id}}">Músicas</button></div>
											<div><button id="btnSalvaAprova" type="button" class="btn btn-primary btn-sm btnSalvaAprova{{$repertorio->id}}" data-id="{{$repertorio->id}}" data-motivo="">Salvar</button></div>
											@endif
										</div>
									</div>
								</h2>
								<div id="collapse{{$repertorio->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$repertorio->id}}" data-bs-parent="#listaRepertorio">
									<div class="accordion-body">
										@if(Count($repertorio['musicas']) > 0)
										<label>Músicas</label><label class="aprovado">Ok</label>
										<ul class="list-group" id="repertorio-{{$repertorio->id}}" role="tablist">
											<?php $active = "active";?>
											@foreach ($repertorio['musicas'] as $musica)
											<li class="list-group-item list-group-item-action {{$active}}">
												<div class="d-flex">
														<a id="linkId-{{$repertorio->id}}-{{$musica->id}}" class="flexAuto list-group-action" data-bs-toggle="modal" data-bs-target="#LetraModal" data-musica="{{$musica->id}}" data-motivo="{{$musica->motivo}}" data-musicaref="{{$repertorio->id}}-{{$musica->id}}">
															<b>{{$musica->categoria->categoria}}</b>
															<small>{{$musica->nome}}</small>
														</a>
														<input id="checkId-{{$repertorio->id}}-{{$musica->id}}" type="checkbox" class="chAprovar" data-id="{{$repertorio->id}}-{{$musica->id}}" {{($musica->motivo == "" ? "checked" : "")}} onclick="return false;" onkeydown="return false;"/>
												</div>
											</li>
											
											<?php $active = "";?>
											@endforeach
										</ul>
										@else
										<label>Nenhuma música selecionada</label>
										@endif
									</div>
								</div>
							</div>
							@endforeach
						@else
							<hr>
							Ainda não existe repertório para aprovação
						@endif
					</div>

				</div>

				<!-- Modal Reprovar -->
				<div class="modal fade" id="ReprovarModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="block">
									<h5 class="modal-title" id="modalLabel"><div class="labelMusica">Reprovação do repertório</div></h5>
								</div>
								
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="tab-content" id="myTabContent">
									<form id="formHeader" class="row">
										<input type="hidden" id="musicaRefInput" value=""/>
										<div class="col-12">
											<label for="modalReprovaRepertorioMotivo" class="form-label">Insira o motivo da reprovação</label> 
											<textarea id="modalReprovaRepertorioMotivo" class="form-control" name="reprova" 
												placeholder="Motivo da reprovação" rows="5"></textarea>
										</div>
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button id="btnSalvaModalReprova" type="button" class="btn btn-primary" data-id="">Salvar</button>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
							</div>
						</div>
					</div>
				</div>

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
								<div class="tab-content" id="myTabContent">
									<form id="formHeader" class="row">
										<input type="hidden" id="modalReprovaRepertorioId" value=""/>
										<div class="col-12">
											<button id="btnReprova" type="button" class="btn btn-danger">Reprovar</button>
											<button id="btnSalvaReprova" type="button" class="btn btn-primary">Salvar</button>
											<a class="btn btn-primary" target="_new" href="editor" role="button">Editor de Texto</a>
										</div>
										<div id="divMotivo" class="col-12 hide" style="padding-top: 15px;">
											<textarea id="musicaReprova" class="form-control" name="reprova" 
												placeholder="Motivo da reprovação" rows="5"></textarea>
										</div>
										<div class="col-12" style="padding-top: 15px;">
											<textarea id="musicaLetra" class="form-control" name="letra" 
												placeholder="Letra da música" rows="20"></textarea>
										</div>
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('javaScript')
			$('#ReprovarModal').on('show.bs.modal', function (event) {
				var elem = $(event.relatedTarget);
				var data = elem.data(); 

				$("#modalReprovaRepertorioId").val(data.id);
				$("#modalReprovaRepertorioMotivo").val(data.motivo);
				$("#btnSalvaModalReprova").attr("data-id", data.id);
			});

			$("#btnSalvaModalReprova").on('click', function(){
				var id = $("#modalReprovaRepertorioId").val();
				var motivo = $("#modalReprovaRepertorioMotivo").val();

				$(".btnSalvaAprova" + id).attr("data-motivo", motivo);
			});

			
			$("#btnReprova").on('click', function(){
				$('#divMotivo').show();
				$("#btnReprova").hide();
				$('#btnSalvaReprova').show();
			});

			$("#btnSalvaReprova").on('click', function(){
				var id = $('#musicaRefInput').val();
				var motivo = $('#musicaReprova').val();
				if (motivo != ""){
					$("#checkId-"+id).prop("checked", false);
				}else{
					$("#checkId-"+id).prop("checked", true);
				}
				$("#linkId-"+id).data("motivo", motivo);
				$('#LetraModal').modal('hide');
			});

			$("#btnSalvaAprova").on('click', function(e){
				var btn = $(e.currentTarget);
				var data = btn.data(); 
				var musicas = [];

				var lista = $("#repertorio-" + data.id + " li");
				if (lista){
					$(lista).each(function(i, elm) {
						var obj = $(elm).find("a").data();
						musicas.push(obj);
					});
					var musicasStr = JSON.stringify(musicas);

					var dataSend = {
						'_token': $('meta[name=csrf-token]').attr('content'),
						id: data.id,
						motivo: data.motivo,
						musicas: musicasStr,
					};

					var jqxhr = $.post( "{{url("aprovacao/update")}}", dataSend, function(response) {
						$("#repertorioItem-" + data.id).remove();
					})
					.done(function(response) {
						alert( "Repertório respondido com sucesso" );
					})
					.fail(function(response) {
						var msg = response.responseJSON.message;
						alert("Ohh não, algo deu errado! O repertório não pôde ser analisado!\n" + msg);
					});
				}
			});

			$('#LetraModal').on('show.bs.modal', function (event) {
				$('#divMotivo').hide();
				$('#btnSalvaReprova').hide();
				$("#btnReprova").show();

				var elem = $(event.relatedTarget);
				var data = elem.data(); 
				var url = "{{url('musicas/letra')}}/"+data.musica;
				var motivo = data.motivo;
				$('#musicaRefInput').val(data.musicaref);

				$('#musicaReprova').val(motivo);
				if( motivo != ""){
					$('#divMotivo').show();
					$("#btnReprova").hide();
					$("#btnSalvaReprova").show();
					$('#musicaReprova').val(motivo);
				}

				var jqxhr = $.get( url , null, function(response){})
					.done(function(response) {
						var musica = response.nome;
						var autor = response.autor;
						var letra = response.letra;
						var slides = response.slides;

						$('#LetraModal .labelMusica').html("Música: "+musica);
						$('#LetraModal .labelAutor').html("<small>Autor: "+autor+"</small>");
						$("#musicaLetra").val(letra);
					})
					.fail(function(response) {
						var msg = response.responseJSON.message;
						alert("Ohh não, algo deu errado!\n" + msg);
						$('#LetraModal').modal('hide');
					});
			});
@endsection