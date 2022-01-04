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

				<div class="col-12 col-sm-6 col-md-2">
    				<label for="dataRef" class="form-label">Semana de referência:</label> 
					<select id="dataRef" class="form-select" name="dataRef" aria-label="Selecione a semana de  referencia">
    					<option value="">Selecione...</option>
						@foreach ($sabados as $sabado)
							<option value="{{$sabado}}">{{dataFormat($sabado)}}</option>
						@endforeach
    				</select>
    			</div>

				<div id="divTipo" class="col-12 col-sm-6 col-md-2">
    				<label for="frmtipo" class="form-label">Tipo de escala:</label> 
					<select id="frmtipo" class="form-select" name="tipo" aria-label="Selecione o tipo de escala">
    					<option value="">Selecione...</option>
						@foreach ($tipos as $tipo)
							<option value="{{$tipo->id}}">{{$tipo->descricao}}</option>
						@endforeach
    				</select>
    			</div>

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
										<button id="btnRemoveCard" type="button" class="btn btn-secondary btnRemoveCard" data-select="cardsAvulso:seqAvulso">Remover</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="missasList" class="row">
					
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
$("#divTipo").hide();
$("#missasList").hide();

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

	$("#escalaItems").val(JSON.stringify(arr));
	$("#qtdeEscalas").val($(".cards:visible").length);
}

function setCard(e){
	var obj = e.currentTarget;
	var data = $(obj).data();

	var descricao = $("."+ data.select + " input[name='frmDescricao']").val();
	var ministerio = $("."+ data.select + " .ministerioSel").val();
	var dataEventoTime = $("."+ data.select + " input[name='frmHoraEvento']").val();
	var dataEventoData = $("."+ data.select + " input[name='itemDataEventoData']").val();
	
	$("."+ data.select + " .inputDescricao").val(descricao);
	$("."+ data.select + " .inputMinisterio").val(ministerio);
	$("."+ data.select + " .inputDataEventoData").val(dataEventoData);
	$("."+ data.select + " .inputDataEventoTime").val(dataEventoTime);

	setJson();
}

function removeCard(e){
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
};

$('#formEscala').submit(function() {
	$('.spinner').removeClass('ocultar');
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
	$(".ministerioSel, .cardDescricao").unbind("change");
	$(".ministerioSel, .cardDescricao").bind("change", function(e){setCard(e);});
	$(".btnRemoveCard").unbind("click");
	$(".btnRemoveCard").bind("click", function(e){removeCard(e);});
});

$("#dataRef").on('change', function(){
	var val = $("#dataRef").val().substring(0,10);
	if(val != ""){
		var elem = $(event.relatedTarget);
		var url = "{{url('escalas/novo')}}/"+val;

		var jqxhr = $.get( url , null, function(response){})
			.done(function(response) {
				$("#missasList").html(response);
				$(".ministerioSel, .cardDescricao").unbind("change");
				$(".ministerioSel, .cardDescricao").bind("change", function(e){setCard(e);});

				$(".btnRemoveCard").unbind("click");
				$(".btnRemoveCard").bind("click", function(e){removeCard(e);});

				$("#divTipo").show();

				setJson();
			})
			.fail(function(response) {
				var msg = "";//response.responseJSON.message;
				alert("Ohh não, algo deu errado!\n" + msg);
			});
	}else{
		$("#divTipo").hide();
	}
});

$("#frmtipo").on('change', function(){
	var val = $("#frmtipo").val();
	if(val != ""){
		$(".cards").hide();
		$(".cards" + val).show();
		$("#missasList").show();

		setJson();
	}else{
		$("#missasList").hide();
	}
});
@endsection