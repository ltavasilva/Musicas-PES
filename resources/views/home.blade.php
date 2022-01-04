@extends('layouts.master')

@section('title', "Menu Principal")

@section('customHead')
		<meta name="csrf-token" content="{{ Session::token() }}">
		<style>
			.space{margin: 6px 0px 6px 0px;}
            .float-right{float: right;}
		</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach (menuArray() as $menu=>$item)
        <div class="col-md-4 cards space ">
            <div class="card">
                <div class="card-header">{{$item[0]}} <a href="{{url("$menu")}}" class="btn btn-primary btn-sm float-right">Abrir</a></div>
                    <div class="card-body">
                        {{$item[1]}}
                    </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
