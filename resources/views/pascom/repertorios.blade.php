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
    		<form id="formHeader" class="row g-3 col-12 col-sm-12">
    
    			<div id="divRepertorios">
    
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
    							<tr data-id="{{$repertorio->id}}" class="{{$repertorio->statusClass}}"> 
									<th scope="row" class="colId rowRef">{{$repertorio->id}}</th>
									<td class="col-2">{{$repertorio->dataEvento}}</td>
									<td class="col-3">{{$repertorio->descricao}}</td>
									<td class="col-1">{{$repertorio->tipo}}</td>
									<td class="col-1"><i data-feather="{{$repertorio->statusIcon}}"></i></td>
									<td class="col-1 last-col">
										<a href="{{url("pascom/view/$repertorio->id")}}"><i data-feather="eye"></i></a>
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

@endsection