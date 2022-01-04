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
    							<th scope="col" class="col-2">Semana</th>
								<th scope="col" class="col-2">Dia da Semana</th>
								<th scope="col" class="col-2">Horário</th>
								<th scope="col" class="col-2">Ministério</th>
								<th scope="col" style="width: 0.1%;">Ações</th>
    						</tr>
    					</thead>
    					<tbody>
							@foreach ($escalaTemplates as $template)
    							<tr data-id="{{$template->id}}"> 
									<th scope="row" class="colId rowRef">{{$template->id}}</th>
									<td class="col-1">{{$template->idSemanaMes}}º Semana</td>
									<td class="col-2">{{$template->getIdDiaSemanaStrAttribute()}}</td>
									<td class="col-1">{{($template->missa) ? $template->missa->getDataEventoTimeAttribute() : ''}}</td>
									<td class="col-1">{{($template->ministerio) ? $template->ministerio->nome : ''}}</td>
									<td class="col-1 last-col">
										<a href="#" data-bs-toggle="modal" data-bs-target="#templateModal"
											data-id="{{$template->id}}" data-idSemanaMes="{{$template->idSemanaMes}}º Semana" data-idDiaSemana="{{$template->getIdDiaSemanaStrAttribute()}}" 
											data-horario="{{$template->missa->getDataEventoTimeAttribute()}}" data-ministerio="{{($template->ministerio) ? $template->ministerio->id : ''}}"><i data-feather="edit"></i></a>
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
								<div class="col-12">
									<label for="frmSemana" class="form-label">Semana:</label>
									<input type="text" id="frmSemana" class="form-control" readonly>
								</div>
				
								<div class="col-12">
									<div>
										<label for="frmDiaSemana" class="form-label">Dia da Semana:</label>
										<input type="text" id="frmDiaSemana" class="form-control" readonly>
									</div>
								</div>

								<div class="col-12">
									<div>
										<label for="frmHorario" class="form-label">Horário:</label>
										<input type="text" id="frmHorario" class="form-control" readonly>
									</div>
								</div>
				
								<div class="col-12 horaEvento">
									<label for="frmMinisterio" class="form-label">Ministério:</label>
										<select id="frmMinisterio" class="form-select" name="idMinisterio" aria-label="Selecione o ministério">
											<option value="">Selecione...</option>
											@foreach ($ministerios as $ministerio)
												<option value="{{$ministerio->id}}">{{$ministerio->nome}}</option>
											@endforeach
										</select>
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
			$('#frmSemana').trigger('focus');
		})
		$('#templateModal').on('show.bs.modal', function (event) {
			var elem = $(event.relatedTarget);
			var data = elem.data(); 
			$("#frmTemplate").prop("action", "{{url($formAction)}}/update");

			$("#frmId").val(data.id);
			$("#frmSemana").val(data.idsemanames);
			$("#frmDiaSemana").val(data.iddiasemana);
			$("#frmHorario").val(data.horario);
			$("#frmMinisterio").val(data.ministerio);
		});

		$("#btnSaveModal").on('click', function(){
			$("#frmSemana").removeAttr('disabled');
			$("#frmSemana").removeAttr("tabindex");
			$("#frmSemana").removeAttr("aria-disabled");

			$("#frmDiaSemana").removeAttr('disabled');
			$("#frmDiaSemana").removeAttr("tabindex");
			$("#frmDiaSemana").removeAttr("aria-disabled");

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