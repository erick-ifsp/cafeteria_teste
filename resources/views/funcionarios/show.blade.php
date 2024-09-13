@extends('layouts.gerenciamento')

@section('content')
<h1>Detalhes do Funcionario</h1>
    <p>ID: {{ $funcionario->id }}</p>
    <p>Nome: {{ $funcionario->nome }}</p>
    <p>CPF: {{ $funcionario->cpf }}</p>
    <p>Salario: {{ $funcionario->salario }}</p>
    <a href="{{ route('funcionarios.index') }}">Voltar</a>
@endsection