@extends('layouts.master')

@section('title', "$title")

@section('customHead')
        <style>
			textarea{
				border: 0px solid #999999;
    			width: 100%;
            }
        </style>
@endsection

@section('content')
		<div class="container">
    		<h2>Sistema de gerenciamento de repertórios da PES</h2>
    		<br>
    		@foreach ($repertorioMusicas as $musica)
				<h4>{{ $musica->categoria }}</h4>
				<h5>{{ $musica->nome }}</h5>
				<h6>{{ $musica->autor }}</h6>
				{{-- <p>{{ $musica->letra }}</p> --}}
				<textarea class="musicaSlides" name="letra" rows="1">{{ $musica->letra }}</textarea>
				<hr>
			@endforeach
    	</div>
@endsection

@section('javaScript')
	function autosize(){
		$('textarea').css('overflow', 'hidden').height($('textarea').prop("scrollHeight"));
	}

	autosize();
@endsection