@extends('layouts.gerenciamento')

@section('content')
<h1>Detalhes da Despesa</h1>
    <p>ID: {{ $despesa->id }}</p>
    <p>Nome: {{ $despesa->nome }}</p>
    <p>Descrição: {{ $despesa->descricao }}</p>
    <p>Valor: {{ $despesa->valor }}</p>
    <a href="{{ route('despesas.index') }}">Voltar</a>
@endsection