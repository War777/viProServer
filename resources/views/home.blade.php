<?
	
	use App\Own\Own;

?>

@extends('layout')

@section('title')
	Bienvenido
@stop

@section('h1')
	Bienvenid@ Yaniviendo {{ Auth::user()->names }}
@stop

@section('content')

@stop
