<?
	
	use App\Own\Own;

?>

@extends('layout')

@section('title')
	Bienvenido
@stop

@section('h1')
	Bienvenid@ {{ Auth::user()->names }}
@stop

@section('content')

@stop
