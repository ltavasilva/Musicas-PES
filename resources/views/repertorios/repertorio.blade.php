@extends('layouts.master')

@section('title', "$title")

@section('customHead')
		<meta name="csrf-token" content="{{ Session::token() }}">
		<style>
			.motivoRecusa{
				text-align: center;
				width: 100%;
			}
		</style>
@endsection

@section('content')
		<div class="d-flex justify-content-center spinner ocultar">
			<div class="spinner-border text-light" role="status">
				
			</div>
			<span class="sr-only text-light">Loading...</span>
		</div>
		<div class="container">
    		<h2>Sistema de gerenciamento de repertórios da PES</h2>
    		<br>
    		<form id="formHeader" class="row g-3 col-12 col-sm-12">
    
    			<div class="col-12 col-sm-12 col-md-3">
    				<label for="ministerio" class="form-label">Ministério de música:</label> 
					<select id="ministerio" class="form-select" name="ministerio" aria-label="Selecione o tipo" {{($mode == "New") ? '' : 'disabled tabindex="-1" aria-disabled="true"'}}>
    					<option value="">Selecione...</option>
						@if(isset($ministerios))
						@foreach ($ministerios as $value)
						<option value="{{$value->id}}"{{($value->id == old("idMinisterio", (isset($ministerio->id) ? $ministerio->id : ''))) ? ' selected' : ''}}>{{$value['nome']}}</option>
						@endforeach
						@endif
    				</select>
    			</div>

				<div class="col-12 col-sm-6 col-md-3">
    				<label for="descricao" class="form-label">Descrição:</label> 
					<input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do evento" {{($editing) ? '' : 'readonly'}} 
						value="{{ old('descricao', $repertorio->descricao) }}">
    			</div>

				<div class="col-12 col-sm-6 col-md-2">
    				<div>
    					<label for="tipoRep" class="form-label">Tipo de repertório:</label>
    					<select id="tipoRep" class="form-select" name="tipoRep" {{($mode == "New") ? '' : 'disabled tabindex="-1" aria-disabled="true"'}}
    						aria-label="Selecione o tipo">
    						<option value="">Selecione...</option>
    						<option value="Missa"{{ (old("tipo", $repertorio->tipo) == "Missa") ? ' selected' : '' }}>Missa</option>
    						<option value="Geral"{{ (old("tipo", $repertorio->tipo) == "Geral") ? ' selected' : '' }}>Geral</option>
    					</select>
    				</div>
    			</div>
    
    			<div class="col-12 col-sm-6 col-md-2">
    				<label for="dataEvento" class="form-label">Data do evento:</label> 
					<input type="date" class="form-control" id="dataEvento" name="dataEvento" {{($mode == "New") ? '' : 'readonly'}} value="{{old("dataEventoDate", $repertorio->dataEventoDate)}}">
    			</div>

				<div class="col-12 col-sm-6 col-md-2">
    				<label for="horaEvento" class="form-label">Hora do evento:</label> 
					<input type="time" class="form-control" id="horaEvento" name="horaEvento" {{($mode == "New") ? '' : 'readonly'}} value="{{old("DataEventoTime", $repertorio->DataEventoTime)}}">
    			</div>
			</form>
			@if ($repertorio->status == 3)
				<div class="row" style="margin-top: 17px;">
					<div class="col-6 d-flex flex-row-reverse"><h3>Status</h3></div>
					<div class="col-6"><h3>Motivo da recusa</h3></div>
					<div class="col-6 d-flex flex-row-reverse"><h6><span class='{{$repertorio->getStatusColorAttribute()}}'><i data-feather='{{$repertorio->getStatusIconAttribute()}}'></i> {{$repertorio->getStatusStrAttribute()}}</span></h6></div>
					<div class="col-6"><h6>{{$repertorio->motivo}}</h6></div>
				</div>
			@endif
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
			@if ($editing)
			<table class="hide">	
				<tbody id=RowTemplate>
					<tr data-id=":idRepertorio" data-sequencia=":sequencia" data-musica=":musica" data-aprovado=":aprovado" data-categoria=":categoria"
						data-categoriaStr=":categStr" data-nome=":musiStr" data-autor=":autStr">
						<th scope="row" class="rowRef">
							<p>:sequencia</p>
						</th>
						<td>
							<div class="card">
								<div class="card-body">								
									<div class="actionCard">
										<div class="commandCard">
											<a href="#" class="addMusica" data-bs-toggle="modal" data-bs-target="#NovaMusicaModal" data-modo="add"
												data-categoria=":categoria" data-sequencia=":sequencia">
												<i data-feather="plus-square"></i>
											</a>
											<a href="#" class="editMusica" data-bs-toggle="modal" data-bs-target="#NovaMusicaModal" data-modo="edit"
												data-categoria=":categoria" data-sequencia=":sequencia" data-musica=":musica">
												<i data-feather="edit"></i>
											</a>
											<a href="#" class="delMusica"  data-modo="del"
												data-categoria=":categoria" data-sequencia=":sequencia" data-musica=":musica">
												<i data-feather="trash-2"></i>
											</a>
										</div>
										<div class="actionLetra">
											<button type="button" aria-label="View" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#LetraModal" 
												data-musica=":musica">
												<i data-feather="book-open"></i> ver a Letra
											</button>
										</div>
										<div class="btnUpDown">
											<i class="moveUp" data-feather="arrow-up"></i>
											<i class="moveDown" data-feather="arrow-down"></i>
										</div>
									</div>
									<div>
										<h4 class="card-title">:categStr</h4>
									</div>
									<div class="musicaInfo">
										<h5 class="card-subtitle text-muted item">
											<span class="tituloCard">Música</span> 
											<p> :musiStr</p>
										</h5>
										<h6 class="card-subtitle text-muted detail">
											<span class="tituloCard">Autor</span> 
											<p> :autStr</p>
										</h6>
									</div>
									<div class="motivoRecusa row">
										<div class="col-6 d-flex flex-row-reverse aprovado">
											:aprovadoStr
										</div>
										<div class="col-6 d-flex motivo">
											:motivoRecusa
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			@endif	

			<form id="formRepertorio" method="POST" action="{{url($formAction)}}">
				@csrf

				<input type="hidden" id="repertorioId" name="id" value="{{old("id", $repertorio->id)}}">
				<input type="hidden" id="repertorioDataEvento" name="dataEvento" value="{{old("dataEvento", $repertorio->dataEvento)}}">
				<input type="hidden" id="repertorioDataEventoDate" name="dataEvento" value="{{old("dataEvento", $repertorio->dataEventoDate)}}">
				<input type="hidden" id="repertorioDataEventoTime" name="horaEvento" value="{{old("horaEvento", $repertorio->dataEventoTime)}}">
				<input type="hidden" id="repertorioIdMinisterio" name="idMinisterio" value="{{old("idMinisterio", (isset($ministerio->id)) ? $ministerio->id : "")}}">
				<input type="hidden" id="repertorioTipo" name="tipo" value="{{old("tipo", $repertorio->tipo)}}">
				<input type="hidden" id="repertorioStatus" name="status" value="1">
				<input type="hidden" id="repertorioDescricao" name="descricao" value="{{old("descricao", $repertorio->descricao)}}">
				<input type="hidden" id="repertorioMusicasJson" name="musicasJson" value="{{old("musicasJson", $repertorio->musicasJson)}}">

				<button type="submit" class="btn btn-primary btn-sm float-end" id="btnSubmit">
					<i data-feather="save"></i> Salvar
				</button>
			</form>

			<div id="divMusicas">
				@if ($editing)
				<button type="button" aria-label="Add" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#NovaMusicaModal" data-modo="add">
					<i data-feather="plus-circle"></i> Nova música
				</button>	

				<button type="button" class="btn btn-primary btn-sm" id="btnDefMomentos">
					<i data-feather="list"></i> Carregar músicas
				</button>

				<!-- Modal Musicas -->
				<div class="modal fade" id="NovaMusicaModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-modo="">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalLabel">Inserir música no repertório</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"
									aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<form id="formHeader" class="row g-3 col-12">
									<div class="col-4 col-sm-2">
										<label for="rowIdModal" class="form-label">Ordem</label> 
										<input type="number" class="form-control" id="rowIdModal" name="rowIdModal" min="1" max="3">
									</div>
									<div class="col-8 col-sm-4">
										<label for="categoriaModal" class="form-label">categoria:</label> 
										<select id="categoriaModal" class="form-select" name="categoria" aria-label="categoria do repertório">
											<option value="">Selecione...</option>
											@if(isset($categorias))
											@foreach ($categorias as $cat)
											<option value={{$cat->id}} class="{{$cat->tipo}}">{{$cat->categoria}}</option>
											@endforeach
											@endif
										</select>
									</div>
									<div class="col-12 col-sm-6">
										<label for="musicaModal" class="form-label">Música</label> 
										<select id="musicaModal" class="form-select" name="musica" aria-label="Música">
											<option value="">Selecione...</option>
											@if(isset($musicas))
											@foreach ($musicas as $musica)
											<option value={{$musica->id}} data-categorias="{{$musica->categorias}}" data-autor="{{$musica->autor}}" data-letra="{{$musica->letra}}">{{$musica->nome}}</option>
											@endforeach
											@endif
										</select>
									</div>
									<div class="col-12 previewLetra">
										<label for="previewLetra" class="form-label">Letra</label> 
										<textarea id="previewLetra" class="form-control" name="letra" placeholder="Letra da música" rows="10"></textarea>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
								<button type="button" id="btnSaveModal" class="btn btn-primary">Salvar</button>
							</div>
						</div>
					</div>
				</div>
				@endif

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
						
					</tbody>
				</table>
			</div>
    	</div>
@endsection

@section('javaScript')
		@if ($editing)
			var isError = {!!($errors->any()) ? 'true' : 'false' !!};
			function setMusicasObj(){
				var json = [];
				$("#repertorioItem tr").each(function(i, elm) {
					var seq = $(elm).attr("data-sequencia");
					var cat = $(elm).attr("data-categoria");
					var mus = $(elm).attr("data-musica");
					var apr = $(elm).attr("data-aprovado");
					var catStr = $(elm).attr("data-categoriaStr");
					var musStr = $(elm).attr("data-nome");
					var autStr = $(elm).attr("data-autor");

					var obj = {sequencia: seq, idMusica: mus, idCategoria:cat, aprovado:apr,
						categoria: catStr, nome: musStr, autor: autStr, 	
					};
					json.push(obj);
				});
				if(!isError){
					$("#repertorioMusicasJson").val(JSON.stringify(json));
					isError = false;
				}
			}

			function setTemplateRow(obj){
				var template = $("#RowTemplate").html();
					template = template.replaceAll(':idRepertorio', obj.idRepertorio);
					template = template.replaceAll(':sequencia', obj.sequencia);
					template = template.replaceAll(':categoria', obj.idCategoria);
					template = template.replaceAll(':musica', obj.idMusica);
					template = template.replaceAll(':aprovadoStr', obj.aprovadoStr);
					template = template.replaceAll(':aprovado', obj.aprovado);
					template = template.replaceAll(':categStr', obj.categoria);
					template = template.replaceAll(':musiStr', obj.nome);
					template = template.replaceAll(':autStr', obj.autor);
					template = template.replaceAll(':motivoRecusa', obj.motivo);

					$("#repertorioItem").append(template);
					$(".delMusica").click(btnDelMusica);
					$(".moveUp,.moveDown").click(moveUpDown);
					feather.replace();
			}

			function setMusicasList(){
				var json = $("#repertorioMusicasJson").val();
				if (json){
					var obj = JSON.parse(json);
					$(obj).each(function(i, elm) {
						setTemplateRow(elm);
					});
				}
			}

			var moveUpDown = function(){
				var row = $(this).parents("tr:first");
				if ($(this).is(".moveUp")) {
					row.insertBefore(row.prev());
				} else {
					row.insertAfter(row.next());
				}

				$("#repertorioItem tr").each(function(i, elm) {
					$(elm).attr("data-sequencia", i+1);
					$(elm).find(".addMusica, .editMusica, .delMusica").attr("data-sequencia", i+1);
					$(elm).children("th").children("p").text(i + 1);
				});
			}

			$('#formRepertorio').submit(function() {
				$('.spinner').removeClass('ocultar');
			});

			$("#ministerio").on('change', function(){
				var valor = $("#ministerio").val();

				$("#repertorioIdMinisterio").val(valor);
			});

			$("#descricao").on('change', function(){
				var valor = $("#descricao").val();

				$("#repertorioDescricao").val(valor);
			});

			$("#dataEvento, #horaEvento").on('change', function(){
				var data = $("#dataEvento").val();
				var hora = $("#horaEvento").val();
				$("#repertorioDataEvento").val(data + ' ' + hora + ':00');
				$("#repertorioDataEventoDate").val(data);
				$("#repertorioDataEventoTime").val(hora);
			});

			$("#tipoRep").on('change', function(){
				var valor = $("#tipoRep").val();

				$("#repertorioTipo").val(valor);
			});

			var btnDelMusica = function(){
				$(this).closest("tr").remove();
				setMusicasObj();
			}

			setMusicasList();
			setMusicasObj();

			$('#NovaMusicaModal').on('shown.bs.modal', function (event) {
				$('#rowIdModal').trigger('focus')
			})
			$('#NovaMusicaModal').on('show.bs.modal', function (event) {
				var elem = $(event.relatedTarget);
				var data = elem.data(); 
				var tipoRepertorio = $("#tipoRep").val();
				var local = (tipoRepertorio == "Missa") ? 'a missa' : 'o repertório';
				$('#NovaMusicaModal').attr("data-modo", data.modo);

				if(data.modo === "add"){
					$(this).find('.modal-title').text('Inserir categoria d' + local);

					var newRow = getRowCount() + 1;
					$("#rowIdModal").val(newRow);
					$("#categoriaModal").prop("selectedIndex", 0);
					$("#musicaModal").prop("selectedIndex", 0);
				}else{
					$(this).find('.modal-title').text('Alterar o categoria d' + local);
					$("#rowIdModal").val(data.sequencia);
					$("#categoriaModal").val(data.categoria).change();
					$("#musicaModal").val(data.musica).change();
				}
				
			});

			$( "#categoriaModal" ).on( "change", function(e) {
				var categoriaModal = $("#categoriaModal").val();
				$("#musicaModal option").hide();
				if(categoriaModal != ""){
					$("#musicaModal option:first").show();
					$("#musicaModal option[data-categorias*="+categoriaModal+"]").show();
				}
			});

			$("#btnSaveModal").on('click', function(){
				var obj = {
					idRepertorio: '{{$repertorio->id}}',
					sequencia: $("#rowIdModal").val(),
					idCategoria: $("#categoriaModal").val(), 
					idMusica: $("#musicaModal").val(),
					aprovado: 1,
					aprovadoStr: "<span class='{{str_replace('bg', 'text', $status->where('id', "=", 1)->first()->objetoStyle)}}'><i data-feather='{{$status->where('id', "=", 1)->first()->icon}}'></i> {{$status->where('id', "=", 1)->first()->descricao}}</span>",
					motivo: "",
					categoria: $("#categoriaModal option:selected").text(),
					nome: $("#musicaModal option:selected").text(),
					autor: $("#musicaModal option:selected").data('autor'),
				};

				var modo = $("#NovaMusicaModal").data("modo");

				if (modo == "add"){
					setTemplateRow(obj);
				}else{
					var row = '#tblMusicas > tbody > tr[data-sequencia='+ obj.sequencia +']';
					$(row).attr("data-musica", obj.idMusica);
					$(row).attr("data-nome", obj.nome);
					$(row).attr("data-autor", obj.autor);
					$(row+" .editMusica, .delMusica, .actionLetra button").attr("data-musica", obj.idMusica);
					$(row+" .musicaInfo .item p").text(obj.nome);
					$(row+" .musicaInfo .detail p").text(obj.autor);
					$(row+" .motivoRecusa .aprovado").text(obj.aprovadoStr);
					$(row+" .motivoRecusa .motivo").text(obj.motivo);
				}
				$("#repertorioStatus").val("1");

				$('#NovaMusicaModal').modal('hide');
				
				setMusicasObj();
			});
			$(".delMusica").click(btnDelMusica);
		@endif
			function getRowCount(){
				var missaRowNum = $('#tblMusicas >tbody >tr').length;
				return missaRowNum;
			}
			function setRowCount(){
				var missaRowNum = getRowCount();
				$("#rowIdModal").attr("max", missaRowNum);
			}

			function addRow(index){
				html = $("#missaRowTemplate").html();
				$('#tblMusicas > tbody > tr:eq(' + index + ')').after(html);

				setRowCount();
			}

			$(".previewLetra").hide();
			$("#musicaModal").on('change', function(e){
				var obj = $("#musicaModal option:selected");
				var val = obj.text();
				if(val == "Selecione..."){
					$(".previewLetra").hide();
				}else{
					$("#previewLetra").val(obj.data("letra"));
					$(".previewLetra").show();
				}
			});
			setRowCount();
			$("#missaRowTemplate, #divGeral" ).hide();
			if($("#tipoRep").val() == "Missa"){
				$("#btnDefMomentos").show();
			}else{
				$("#btnDefMomentos").hide();
			}

			$("#btnDefMomentos").on('click', function(){
				var canLoad = false;
				var reg = {!! $categoriasMissa !!};
				if(getRowCount() > 0){
					if(confirm("As músicas listadas serão excluídas! Deseja continuar?")){
						canLoad = true;
					}
				}else{
					canLoad = true;
				}

				if(canLoad == true){
					$('#repertorioItem').html("");


					$(reg).each(function(i, elm) {
						var obj = {
							idRepertorio: '{{$repertorio->id}}',
							sequencia: i+1,
							idCategoria: elm.id, 
							idMusica: "",
							aprovado: 1,
							categoria: elm.categoria,
							nome: "",
							autor: "",
						};
		
						setTemplateRow(obj);
					});
					$(".moveUp,.moveDown").click(moveUpDown);
					$(".delMusica").click(btnDelMusica);
					setMusicasObj();
				}
			});

			$( "#tipoRep" ).on( "change", function(e) {
				var tipoRep = $("#tipoRep").val();
				if(tipoRep == "Missa"){
					$("#btnDefMomentos").show();
				}else{
					$("#btnDefMomentos").hide();
				}
				@if ($editing)
				$("#categoriaModal option").hide();
				$("#musicaModal option:first").show();
				$("#categoriaModal ."+tipoRep).show();
				@endif
			});

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