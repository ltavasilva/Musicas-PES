@extends('layouts.master')

@section('title', "$title")

@section('customHead')
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
        </style>
@endsection

@section('content')
		<div class="container">
    		<h2>Sistema de gerenciamento de repertórios da PES</h2>
    		<br>
			
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if (isset($errorMsg))
				<div class="alert alert-danger">
					<ul>
						<li>{{ $errorMsg }}</li>
					</ul>
				</div>
			@endif

    		<form id="formHeader" class="row g-3 col-12 col-sm-12">
    			<div id="divTemplates">
    				<a id="btnNewTemplate" href="#" aria-label="Add" data-bs-toggle="modal" data-bs-target="#templateModal" data-modo="add" class="btn btn-primary btn-sm">
    					<i data-feather="plus-circle"></i> Novo template
    				</a>
    
    				<table id="tblTemplates" class="table table-striped table-hover">
    					<thead>
    						<tr>
    							<th scope="col" class="col-1" style="width: 10px; vertical-align: middle;">#</th>
    							<th scope="col" class="col-2">Hora</th>
								<th scope="col" class="col-4">Descrição</th>
								<th scope="col" class="col-2">Tipo</th>
								<th scope="col" style="width: 0.1%;">Ações</th>
    						</tr>
    					</thead>
    					<tbody>
							@foreach ($templates as $template)
    							<tr data-id="{{$template->id}}"> 
									<th scope="row" class="colId rowRef">{{$template->id}}</th>
									<td class="col-2">{{$template->DataEventoTime}}</td>
									<td class="col-3">{{$template->descricao}}</td>
									<td class="col-1">{{$template->tipoStr}}</td>
									<td class="col-1 last-col">
										<a href="#" data-bs-toggle="modal" data-bs-target="#templateModal"
											data-id="{{$template->id}}" data-descricao="{{$template->descricao}}" data-tipo="{{$template->tipo}}" data-diasemana = "{{$template->idDiaSemana}}" data-data="{{$template->dataEventoDate}}" data-hora="{{$template->dataEventoTime}}"><i data-feather="edit"></i></a>
										<a href="#" class="linkDel" data-id="{{$template->id}}"><i data-feather="trash-2"></i></a>
									</td>
    							</tr>
							@endforeach
    						
    					</tbody>
    				</table>
    			</div>
    		</form>

			<!-- Modal Template -->
			<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-modo="">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modalLabel">Escala Template</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="frmTemplate" class="row g-3 col-12" method="POST" action="{{url($formAction)}}">
								@csrf
								<input type="hidden" id="frmId" name="id">
								<input type="hidden" class="form-control" id="frmDataEvento" name="dataEvento">
								<div class="col-12">
									<label for="frmDescricao" class="form-label">Descrição:</label> 
									<input type="text" class="form-control" id="frmDescricao" name="descricao" placeholder="Descrição do evento">
								</div>
				
								<div class="col-12">
									<div>
										<label for="frmTipoRep" class="form-label">Tipo de repertório:</label>
										<select id="frmTipoRep" class="form-select" name="tipo" aria-label="Selecione o tipo">
											<option value="">Selecione...</option>
											@foreach ($tipos as $tipo)
											<option value="{{$tipo->tipo}}">{{$tipo->descricao}}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-12">
									<div>
										<label for="frmDiaSemana" class="form-label">Dia da semana:</label>
										<select id="frmDiaSemana" class="form-select" name="idDiaSemana" aria-label="Selecione o tipo">
											<option value="">Selecione...</option>
											@foreach ($dias as $dia)
											<option value="{{$dia->id}}" class="{{$dia->tipo}}">{{$dia->descricao}}</option>
											@endforeach
										</select>
									</div>
								</div>
				
								<div class="col-12 horaEvento">
									<label for="frmHoraEvento" class="form-label">Hora do evento:</label> 
									<input type="time" class="form-control" id="frmHoraEvento" name="horaEvento">
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
    	</div>
@endsection

@section('javaScript')
		$('#templateModal').on('shown.bs.modal', function (event) {
			$('#frmDescricao').trigger('focus');
		})
		$('#templateModal').on('show.bs.modal', function (event) {
			var elem = $(event.relatedTarget);
			var data = elem.data(); 

			var d = new Date();
			var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

			if(data.modo === "add"){
				$("#frmTemplate").prop("action", "{{url($formAction)}}/insert");

				$("#frmTipoRep").removeAttr('disabled');
				$("#frmTipoRep").removeAttr("tabindex");
				$("#frmTipoRep").removeAttr("aria-disabled");

				$("#frmId").val("");
				$("#frmDescricao").val("");
				$("#frmTipoRep").val("");
				$("#frmDiaSemana").val("");
				$("#frmDataEvento").val(strDate);
				$("#frmHoraEvento").val("");
			}else{
				$("#frmTemplate").prop("action", "{{url($formAction)}}/update");

				$("#frmTipoRep").prop("disabled", true);
				$("#frmTipoRep").prop("tabindex", -1);
				$("#frmTipoRep").prop("aria-disabled", "true");

				$("#frmId").val(data.id);
				$("#frmDescricao").val(data.descricao);
				$("#frmTipoRep").val(data.tipo);
				$("#frmDiaSemana").val(data.diasemana);
				$("#frmDataEvento").val(data.data);
				if(data.tipo == 'Avulso'){
					$("#frmHoraEvento").val("");
					$(".horaEvento").hide();
				}else{
					$("#frmHoraEvento").val(data.hora);
					$(".horaEvento").show();
				}
				
			}
		});

		$("#btnSaveModal").on('click', function(){
			$("#frmTipoRep").removeAttr('disabled');
			$("#frmTemplate").submit();
		});
		$(".linkDel").click(function(event){
			var elem = $(event.currentTarget);
			var data = elem.data(); 
			if (confirm('Tem certeza que deseja excluir este registro?')) {
				$("#frmTemplate").prop("action", "{{url($formAction)}}/delete");
				$("#frmId").val(data.id);
				$("#frmTemplate").submit();
			}
		});

		$("#frmTipoRep").on('change', function(e){
			var tipo = $("#frmTipoRep").val();
			if(tipo == 'Avulso'){
				$(".horaEvento").hide();
			}else{
				$(".horaEvento").show();
			}
		});
		

@endsection