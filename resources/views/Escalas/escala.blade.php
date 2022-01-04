@extends('layouts.master')

@section('title', "$title")

@section('customHead')
		<meta name="csrf-token" content="{{ Session::token() }}">
		<style>
			.motivoRecusa{
				text-align: center;
				width: 100%;
				color: red;
			}
			.space{margin: 6px 0px 6px 0px;}
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
			<form id="formEscala" class="row g-3 col-12 col-sm-12" method="POST" action="{{url($formAction)}}">
				@csrf
				<input type="hidden" id="escalaId" name="id" value="{{$escala->id}}">
				<input type="hidden" id="qtdeEscalas" name="qtdeEscalas" value="">
				<input type="hidden" id="escalaItems" name="escalaItems" value="">
				<input type="hidden" id="removeItems" name="removeItems" value="">
				<input type="hidden" id="horaRef" name="horaRef" value="">
				<div class="col-12 col-sm-6 col-md-3">
    				<label for="descricao" class="form-label">Descrição:</label> 
					<input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do evento" {{($editing) ? '' : 'readonly'}} 
						value="{{ old('descricao', $escala->descricao) }}">
    			</div>
				
				@if ($mode == "New")
				<div class="col-12 col-sm-6 col-md-3">
    				<label for="tipo" class="form-label">Tipo:</label> 
					<select id="tipo" class="form-select" name="tipo" aria-label="Selecione o tipo" {{($editing) ? '' : 'readonly tabindex="-1" aria-disabled="true"'}}>
    					<option value="">Selecione...</option>
						@if(isset($tipos))
						@foreach ($tipos as $value)
						<option value="{{$value->id}}"{{($value->id == old("tipo", (isset($escala->tipo->id) ? $escala->tipo->id : '')) ? ' selected' : '')}}>{{$value->descricao}}</option>
						@endforeach
						@endif
    				</select>
    			</div>
				@else
				<div class="col-12 col-sm-6 col-md-3">
    				<label for="tipo" class="form-label">Tipo:</label> 
					<input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo do evento" readonly value="{{ old('tipo', $escala->tipo->descricao) }}">
    			</div>
				@endif
    
    			<div class="col-12 col-sm-6 col-md-2">
    				<label for="dataRef" class="form-label">Data de referência:</label> 
					<input type="date" min="" step="7" class="form-control" id="dataRef" data-value="{{$escala->dataRef}}" name="dataRef" {{($mode == "New") ? '' : 'readonly'}} value="{{ old('dataRef', $escala->dataRef) }}">
    			</div>

				@if ($mode != "New")
				<div class="col-12 col-sm-6 col-md-2">
    				<label for="criacaoInfo" class="form-label">Criação:</label> 
					<div class="form-control" id="criacaoInfo" readonly>{{$escala->created_by->name}}<br>{{$escala->created_at}}</div>
    			</div>

				<div class="col-12 col-sm-6 col-md-2">
    				<label for="alteracaoInfo" class="form-label">Alteração:</label> 
					<div class="form-control" id="criacaoInfo" readonly>{{$escala->updated_by->name}}<br>{{$escala->updated_at}}</div>
    			</div>
				@endif

				<div class="col-12 col-sm-6 col-md-2">
    				<button id="btnAddAvulso" type="button" class="btn btn-primary">Add Missa Avulso</button>
    			</div>

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
			
				<div id="cardTemplate">
					<div class="col-12 col-sm-12 col-md-6 col-lg-4 cards space cardsTemplate cardsAvulso:seqAvulso hide">
						<input type="hidden" class="inputData inputRepertorio" name="itemRepertorio" value="">
						<input type="hidden" class="inputData inputMinisterio" name="itemMinisterio" value="">
						<input type="hidden" class="inputData inputTipo" name="itemTipo" value="Avulso">
						<input type="hidden" class="inputData inputDescricao" name="itemDescricao" value="">
						<input type="hidden" class="inputData inputDataEventoData" name="itemDataEventoData" value="">
						<input type="hidden" class="inputData inputDataEventoTime" name="itemDataEventoTime" value="">
						<div class="card" style="width: 18rem;">
							<div class="card-header">
								<input type="text" class="form-control cardDescricao" id="templateDescricao" name="frmDescricao" data-select="cardsAvulso:seqAvulso" placeholder="Insira a descrição da missa" value="">
							</div>
							<div class="card-body">
								<p class="card-text">
									<h5>Ministério: 
										<select id="templateMinisterio" class="form-select ministerioSel" data-select="cardsAvulso:seqAvulso" name="frmMinisterio" aria-label="Selecione o ministério">
											<option value="" selected>Selecione...</option>
											
											@foreach ($ministerios as $value)
											<option value="{{$value->id}}">{{$value->nome}}</option>
											@endforeach
										</select>
									</h5>
									<div class="col-12">
										<label for="cardDataEvento" class="form-label">Data do evento:</label> 
										<input type="date" class="form-control cardDataEvento" id="cardDataEvento:seqAvulso" name="frmDataEvento" data-select="cardsAvulso:seqAvulso">
									</div>
									<label for="cardHoraEvento" class="form-label">Hora do evento:</label> 
									<input type="time" class="form-control cardHoraEvento" id="cardHoraEvento" data-select="cardsAvulso:seqAvulso" name="frmHoraEvento">
								</p>
								<div class="row">
									<div class="col-6">
										<button id="btnAddAvulso" type="button" class="btn btn-secondary btnRemoveCard" data-select="cardsAvulso:seqAvulso">Remover</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="missasList" class="row">
					@foreach ($escala->repertorios as $repertorio)
					<div class="col-12 col-sm-12 col-md-6 col-lg-4 cards space cards{{$repertorio->tipo}} cardsItem{{$repertorio->id}} hide">
						<input type="hidden" class="inputData inputRepertorio" name="itemRepertorio" value="{{$repertorio->id}}">
						<input type="hidden" class="inputData inputMinisterio" name="itemMinisterio" value="{{$repertorio->ministerio->id}}">
						<input type="hidden" class="inputData inputTipo" name="itemTipo" value="{{$repertorio->tipo}}">
						<input type="hidden" class="inputData inputDescricao" name="itemDescricao" value="{{$repertorio->descricao}}">
						<input type="hidden" class="inputData inputDataEventoData" name="itemDataEventoData" value="{{$repertorio->dataEventoData}}">
						<input type="hidden" class="inputData inputDataEventoTime" name="itemDataEventoTime" value="{{$repertorio->dataEventoTime}}">

						<div class="card {{$repertorio->statusCard}}" style="width: 18rem;">
							<div class="card-header">
								<input type="text" class="form-control cardDescricao" id="frmDescricao" name="frmDescricao" data-select="cardsItem{{$repertorio->id}}" placeholder="Insira a descrição da missal" value="{{$repertorio->descricao}}">
							</div>
							<div class="card-body">
								<p class="card-text">
									@if($editing)
									<h5>Ministério: <select id="ministerio" class="form-select ministerioSel"  data-select="cardsItem{{$repertorio->id}}" name="frmMinisterio" aria-label="Selecione o ministério" {{($editing) ? '' : 'readonly tabindex="-1" aria-disabled="true"'}}>
											<option value="">Selecione...</option>
											
											@foreach ($ministerios as $value)
											<option value="{{$value->id}}"{{($value->id == old("ministerio".$repertorio->ministerio->id, (isset($repertorio->ministerio->id) ? $repertorio->ministerio->id : '')) ? ' selected' : '')}}>{{$value->nome}}</option>
											@endforeach
										</select>
									</h5>
									@endif
									<h6 class="dataEvento">Data: <span class="dataEvento">{{$repertorio->dataEventoDateBr}}</span></h6>
									<div class="col-12">
										<label for="cardHoraEvento" class="form-label">Hora do evento:</label> 
										<input type="time" class="form-control cardHoraEvento" id="cardHoraEvento" name="frmHoraEvento" data-select="cardsItem{{$repertorio->id}}" value="{{$repertorio->dataEventoTime}}" {{($editing) ? '' : 'readonly'}}>
									</div>
								</p>
								
								<div class="row">
									<div class="col-6">
										@if ($mode == "New")
											@if($repertorio->temMusica)
											<a href="{{ url("repertorios/edit/$repertorio->id")}}" class="btn btn-primary">Repertório</a>
											@endif
										@endif
										<button id="btnAddAvulso" type="button" class="btn btn-secondary btnRemoveCard" data-select="cardsItem{{$repertorio->id}}">Remover</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				@if ($submit || $editing) 
                <hr>
                @endif
                @if ($submit)
                <div class="col">
                    <button id="btnSubmit" type="submit" class="btn btn-primary"><i data-feather="plus-circle"></i> Salvar</button>
                @endif
                @if ($editing && $mode != "New")
                    <button id="btnDel" type="button" class="btn btn-primary" data-id="{{$escala->id}}">Remover</button>
                </div>
                @endif
			</form>
    	</div>
@endsection

@section('javaScript')
var seqAvulso = 0;
//$(".dataEvento").hide();
function addDays(date, days) {
	var result = new Date(date);
	result.setDate(result.getDate() + days);
	return result;
}

function selectTipo(){
	
	var tipo = $("#tipo").val();
	
	if(tipo != 'Selecione...'){
		var filtro = "";
		$("#dataRef").attr("step", '7');
		
		if(tipo == 1){
			filtro = "cardsTemplate_DDS";
			$("#dataRef").attr("min", '{{$nextMonday}}');
		}else if(tipo == 2){
			filtro = "cardsTemplate_FDS";
			$("#dataRef").attr("min", '{{$nextSaturday}}');
		}else if(tipo == 3){
			filtro = "cardsAvulso";
			$("#dataRef").attr("min", '{{$today}}');
			$("#dataRef").removeAttr( "step" );
		}
		$(".cards").removeClass('hide');
		$(".cards").hide();
		$("." + filtro).show();
		$("#qtdeEscalas").val($("." + filtro).length);
	}
}

function setJson(){	
	var arr = new Array();

	$("#missasList .cards:visible").each(function(i, card) {
		var sel = new Object();
		$(card).find('.inputData').each(function(i, elm) {
			sel[$(elm).attr("name")] = $(elm).val();
		});

		if(sel.descricao != '' && sel.ministerio != '' && sel.dataEventoData != '' && sel.dataEventoTime != ''){
			arr.push(sel);
		}
	});

	/*var obj = {};
	obj.items = arr;
	obj.remove = 1;*/

	$("#escalaItems").val(JSON.stringify(arr));
	$("#qtdeEscalas").val($(".cards:visible").length);
}

function setCard(e){
	var obj = e.currentTarget;
	var data = $(obj).data();

	var descricao = $("."+ data.select + " input[name='frmDescricao']").val();
	var ministerio = $("."+ data.select + " .ministerioSel").val();
	var dataEventoTime = $("."+ data.select + " input[name='frmHoraEvento']").val();
	var dataEventoData = $("."+ data.select + " input[name='frmDataEvento']").val();

	$("."+ data.select + " .inputDescricao").val(descricao);
	$("."+ data.select + " .inputMinisterio").val(ministerio);
	$("."+ data.select + " .inputDataEventoData").val(dataEventoData);
	$("."+ data.select + " .inputDataEventoTime").val(dataEventoTime);

	setJson();
}

$('#formEscala').submit(function() {
	$('.spinner').removeClass('ocultar');
});

$(".cardHoraEvento").on('change', function(e){
	var elm = e.currentTarget;
	var id = $(elm).data("id");
	var value = $(elm).val();

	$("#ministerio" + id).attr("data-time", value);
	setJson();
});

@if($mode == "New")
$("#tipo").on('change', function(){
	selectTipo();
});
@else
	$(".cards").hide();
	$(".cardsMissa, .cardsAvulso").show();
	setJson();
	$("#qtdeEscalas").val($(".cardsMissa").length);
@endif

$("#dataRef").on('change', function(){
	var val = $("#dataRef").val();
	var parts = val.split("-");
	var dt = new Date(parts[0], parts[1], parts[2]); 

	var tipo = $("#tipo").val();

	var inc=1;
	var datestring;

	if(tipo == 1){
		$(".cardsTemplate_DDS").each(function(i, elm) {
			datestring = dt.getDate() + "/" + dt.getMonth() + "/" + dt.getFullYear();
			$(elm).find(".dataEvento").text(datestring);
			$(elm).find(".ministerioSel").attr('data-date', datestring);
			dt = addDays(dt, inc);
			
		});
	}else if(tipo == 2){
		$(".cardsTemplate_FDS").each(function(i, elm) {
			datestring = dt.getDate() + "/" + dt.getMonth() + "/" + dt.getFullYear();
			$(elm).find(".dataEvento").text(datestring);
			$(elm).find(".ministerioSel").attr('data-date', datestring);
			dt = addDays(dt, inc);
			inc = 0;
		});
	}
	$(".dataEvento").show();
});

$(".ministerioSel, .cardDescricao, .cardHoraEvento, .cardDataEvento").on('change', function(e){
	setCard(e);
});

$("#btnAddAvulso").on('click', function(e){
	var card = $("#cardTemplate").html();
	card = card.replaceAll(':seqAvulso', seqAvulso);

	var seqAvulsoAnt = seqAvulso;
	seqAvulso += 1;
	$("#missasList").append(card);
	$("#cardDataEvento" + seqAvulsoAnt).val($("#dataRef").val());

	$("#missasList .cardsTemplate").show();
	$("#missasList .cardsTemplate").addClass("cardsAvulso");
	$("#missasList .cardsTemplate").removeClass("cardsTemplate");
	$(".ministerioSel, .cardDescricao, .cardDataEvento, .cardHoraEvento").unbind("change");
	$(".ministerioSel, .cardDescricao, .cardDataEvento, .cardHoraEvento").bind("change", function(e){setCard(e);});
});

$("#btnDel").click(function(event){
	var elem = $(event.currentTarget);
	var data = elem.data(); 
	if (confirm('Tem certeza que deseja excluir este registro?')) {
		$("#formEscala").prop("action", "{{url(str_replace('update', 'delete', $formAction))}}");
		$("#escalaId").val(data.id);
		$("#formEscala").submit();
	}
});

$(".btnRemoveCard").click(function(e){
	var elem = $(e.currentTarget);
	var data = elem.data(); 

	if (confirm('Tem certeza que deseja excluir este registro?')) {
		var json = [];
		var rem = $("#removeItems").val();

		if (rem != ""){
			json = JSON.parse(rem);
		}

		json.push({id: $("."+data.select + " .inputRepertorio").val()});

		$("#removeItems").val(JSON.stringify(json));
		$("."+data.select).remove();
	}

	setJson();
});
@endsection