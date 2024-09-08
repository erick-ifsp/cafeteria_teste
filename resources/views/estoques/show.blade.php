@extends('layouts.app')

@section('content')
<h1>Detalhes do Produto no Estoque</h1>
    <p>ID: {{ $estoque->id }}</p>
    <p>Nome: {{ $estoque->nome }}</p>
    <p>quantidade: {{ $estoque->descricao }}</p>
    <p>Preço: {{ $estoque->preco }}</p>
    <a href="{{ route('estoques.index') }}">Voltar</a>
@endsection