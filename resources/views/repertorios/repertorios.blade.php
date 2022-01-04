@extends('layouts.master')

@section('title', "$title")

@section('customHead')
		<link rel="stylesheet" href="{{asset('asset/rzslider/rzslider.css')}}" />
		<script data-require="angular.js@1.6.0" data-semver="1.6.0" src="{{asset('asset/rzslider/angular.js')}}"></script>
		<script data-require="ui-bootstrap@*" data-semver="2.2.0" src="{{asset('asset/rzslider/ui-bootstrap-tpls-2.2.0.js')}}"></script>

		<script src="{{asset('asset/rzslider/rzslider.js')}}"></script>
		<script src="{{asset('js/repertorioRange.js')}}"></script>
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
			.selMinisterio{margin-bottom: 16px;}
        </style>
@endsection

@section('content')
		<div class="container">
    		<h2>Sistema de gerenciamento de repertórios da PES</h2>
    		<br>
			<form id="formHeader" class="row g-3 col-12 col-sm-12" method="POST" action="{{url($formAction)}}">
				@csrf
				<input type="hidden" id="frmId" name="id">
				
				@if(Count($ministerios) > 1)
    			<div class="col-12 col-sm-12 col-md-4">
    				<label for="ministerio" class="form-label">Selecione o seu
    					ministério de música:</label> 
					<select id="ministerio" class="form-select selMinisterio" name="ministerio" aria-label="Selecione o tipo">
						<option value="" selected>Selecione...</option>
						@foreach ($ministerios as $value)
							@if($value->membro == "membro")
								<option value="{{$value['id']}}">{{$value['nome']}}</option>
							@endif
						@endforeach
    				</select>
					<select id="ministerioFull" class="form-select selMinisterio" name="ministerio" aria-label="Selecione o tipo">
    					<option value="" selected>Selecione...</option>
						@foreach ($ministerios as $value)
							<option value="{{$value['id']}}">{{$value['nome']}}</option>
						@endforeach
    				</select>

					<div class="col-12 col-sm-12 col-md-12">
						<input class="form-check-input" type="checkbox" value="0" id="chTodos">
						<label class="form-check-label" for="chTodos">Ver todos os ministérios</label>
					</div>
    			</div>

				<div class="col-12 col-sm-12 col-md-6">
					<input id="filterIni" type="hidden"/>
					<input id="filterFim" type="hidden"/>
					<label for="dataIni" class="form-label">Periodo:</label> 
					<div ng-app="dateRangeDemo" ng-controller="dateRangeCtrl">
						<rzslider
							rz-slider-model="dateRangeSlider.minValue" 
							rz-slider-high="dateRangeSlider.maxValue" 
							rz-slider-options="dateRangeSlider.options">
						</rzslider>
					</div>

					<div class="col-12 col-sm-12 col-md-8">
						<input class="form-check-input" type="checkbox" value="0" id="chTodasDatas">
						<label class="form-check-label" for="chTodasDatas">Todas as Datas</label>
					</div>
				</div>
				@endif

				@if (isset($errorMsg))
					<div class="alert alert-danger">
						<ul>
							<li>{{ $errorMsg }}</li>
						</ul>
					</div>
				@endif

    			<hr>
    
    			<div id="divRepertorios">
    				<a id="btnNewRepertorio" href="{{url('repertorios/novo')}}" aria-label="Add" class="btn btn-primary btn-sm">
    					<i data-feather="plus-circle"></i> Novo repertório
    				</a>
    
    				<table id="tblRepertorios" class="table table-striped table-hover">
    					<thead>
    						<tr>
    							<th scope="col" class="col-1" style="width: 10px; vertical-align: middle;">#</th>
    							<th scope="col" class="col-2">Data</th>
								<th scope="col" class="col-4">Descrição</th>
								<th scope="col" class="col-2">Tipo</th>
								<th scope="col" class="col-1">Status</th>
								<th scope="col" style="width: 0.1%;">Ações</th>
    						</tr>
    					</thead>
    					<tbody>
							@foreach ($repertorios as $repertorio)
    							<tr data-id="{{$repertorio->id}}" data-date="{{$repertorio->getDataEventoDateAttribute()}}" class="repList rep{{$repertorio->ministerio->id}} rep{{$repertorio->membro}} {{$repertorio->statusClass}}"> 
									<th scope="row" class="colId rowRef">{{$repertorio->id}}</th>
									<td class="col-2">{{$repertorio->dataEvento}}</td>
									<td class="col-3">{{$repertorio->descricao}}</td>
									<td class="col-1">{{$repertorio->tipo}}</td>
									<td class="col-1"><i data-feather="{{$repertorio->statusIcon}}"></i></td>
									<td class="col-1 last-col">
										<a href="{{url("repertorios/musicas/$repertorio->id")}}"><i data-feather="eye"></i></a>
										@if(isCoordenador())
										<a href="{{url("repertorios/edit/$repertorio->id")}}"><i data-feather="edit"></i></a>
										<a href="#" class="linkDel" data-id="{{$repertorio->id}}"><i data-feather="trash-2"></i></a>
										@endif
									</td>
    							</tr>
							@endforeach
    						
    					</tbody>
    				</table>
    			</div>
    		</form>
    	</div>
@endsection

@section('javaScript')
	$("#ministerioFull").hide();
	$( ".repList" ).hide();
	$( ".repmembro" ).show();
	
	function filter(){
		var min = $("#filterIni").val();
		var max = $("#filterFim").val();

		setList();

		var todasDatas = $("#chTodasDatas").is(":checked");
		if(!todasDatas){
			$("#tblRepertorios tr:visible").each(function(i, e){
				var check = $(e).data("date");
				
				var filt;
				mini = Date.parse(min);
				maxi = Date.parse(max);
				filt = Date.parse(check);


				if((filt >= mini && filt <= maxi)) {
					$(e).show();
				}else{
					$(e).hide();
				}
			});
		}
	}

	function setList(){
		var isFull = $("#chTodos").is(":checked");
		var valor;
		if(isFull){
			valor = $("#ministerioFull").val();
		}else{
			valor = $("#ministerio").val();
		}

		if(valor != ''){
			$( ".repList" ).hide();
			$( ".rep" + valor ).show();
		}else{
			if(isFull){
				$( ".repList" ).show();
			}else{
				$( ".repList" ).hide();
				$( ".repmembro" ).show();
			}
		}
	}

	$( "#ministerio" ).on( "change", function(e) {
		var url = "{{url('repertorios/novo')}}/";
		var valor = $(this).val();

		filter();		
		
		$( "#btnNewRepertorio" ).attr("href", url+valor);
	});

	$( "#ministerioFull" ).on( "change", function(e) {
		var url = "{{url('repertorios/novo')}}/";
		var valor = $(this).val();

		filter();		
		
		$( "#btnNewRepertorio" ).attr("href", url+valor);
	});

	$( "#chTodos" ).on( "change", function(e) {
		if($(this).is(":checked")){
			$("#ministerio").hide();
			$("#ministerioFull").show();
			if($("#ministerioFull").val() == ""){
				$( ".repList" ).show();
			}
		}else{
			$("#ministerio").show();
			$("#ministerioFull").hide();
			if($("#ministerio").val() == ""){
				$( ".repList" ).hide();
			}
		}
		filter();
	});

	$( "#chTodasDatas" ).on( "change", function(e) {
		filter();
	});

	$(".linkDel").click(function(event){
		var elem = $(event.currentTarget);
		var data = elem.data(); 
		if (confirm('Tem certeza que deseja excluir este registro?')) {
			$("#formHeader").prop("action", "{{url($formAction)}}/delete");
			$("#frmId").val(data.id);
			$("#formHeader").submit();
		}
	});
@endsection