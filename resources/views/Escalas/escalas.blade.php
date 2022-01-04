@extends('layouts.master')

@section('title', "$title")

@section('customHead')
		<link rel="stylesheet" href="{{asset('asset/rzslider/rzslider.css')}}" />
		<script data-require="angular.js@1.6.0" data-semver="1.6.0" src="{{asset('asset/rzslider/angular.js')}}"></script>
		<script data-require="ui-bootstrap@*" data-semver="2.2.0" src="{{asset('asset/rzslider/ui-bootstrap-tpls-2.2.0.js')}}"></script>

		<script src="{{asset('asset/rzslider/rzslider.js')}}"></script>
		<script src="{{asset('js/escalaRange.js')}}"></script>
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
			.colFlex{display: flex;}
			.label{font-weight: 100;line-height: 0.8;}
			.todasDatasDiv{    padding-top: 56px;}
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
    		<form id="formHeader" class="row g-3 col-12 col-sm-12" method="POST" action="{{url($formAction)}}">
				@csrf
				<input type="hidden" id="frmId" name="id">

				<div class="col-12 col-sm-12 col-md-8">
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
				</div>
				<div class="col-12 col-sm-12 col-md-4 todasDatasDiv">
					<input class="form-check-input" type="checkbox" value="0" id="chTodasDatas">
					<label class="form-check-label" for="chTodasDatas">Todas as Datas</label>
				</div>

				@if (isset($errorMsg))
					<div class="alert alert-danger">
						<ul>
							<li>{{ $errorMsg }}</li>
						</ul>
					</div>
				@endif

    			<hr>

				<div id="divEscalas">  
					<a id="btnNewRepertorio" href="{{url('escalas/novo')}}" aria-label="Add" class="btn btn-primary btn-sm">
    					<i data-feather="plus-circle"></i> Nova escala
    				</a>
					  
    				<table id="tblEscalas" class="table table-striped table-hover">
    					<thead>
    						<tr>
    							<th scope="col" class="col-1" style="width: 10px; vertical-align: middle;">#</th>
    							<th scope="col" class="col-2">Descrição</th>
								<th scope="col" class="col-4">Tipo</th>
								<th scope="col" class="col-2">Data Referência</th>
								<th scope="col" class="col-1">Alteração</th>
								<th scope="col" style="width: 0.1%;">Ações</th>		
    						</tr>
    					</thead>
    					<tbody>
							@foreach ($escalas as $escala)
    							<tr data-id="{{$escala->id}}" data-date="{{$escala->dataRef}}" class="rowRef"> 
									<th scope="row" class="colId">{{$escala->id}}</th>
									<td class="col-3">{{$escala->descricao}}</td>
									<td class="col-2">{{$escala->tipo->descricao}}</td>
									<td class="col-2">{{$escala->getDataEventoDateBrAttribute()}}</td>
									<td class="col-3">
										<div>{{$escala->updated_by->name}}<br>{{$escala->updated_at->format('d/m/Y H:i')}}</div>
									</td>
									<td class="col-2 last-col">
										<div class="colFlex">
											<a href="{{url("escalas/edit/$escala->id")}}"><i data-feather="edit"></i></a>
											<a href="#" class="linkDel" data-id="{{$escala->id}}"><i data-feather="trash-2"></i></a>
										</div>
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
	function filter(){
		var min = $("#filterIni").val();
		var max = $("#filterFim").val();

		var todasDatas = $("#chTodasDatas").is(":checked");
		if(!todasDatas){
			$("#tblEscalas tr").each(function(i, e){
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
		}else{
			$("#tblEscalas tr").show();
		}
	}

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

	filter();
@endsection