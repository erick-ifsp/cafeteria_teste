@extends('layouts.gerenciamento')

@section('content')
<h1>Detalhes do Produto</h1>
    <p>ID: {{ $produto->id }}</p>
    <p>Nome: {{ $produto->nome }}</p>
    <p>Preço: {{ $produto->preco }}</p>
    <a href="{{ route('produtos.index') }}">Voltar</a>
@endsection