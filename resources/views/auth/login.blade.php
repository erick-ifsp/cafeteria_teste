@extends('layouts.login')

@section('content')

<div class="login">
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <div class="col-md-5 align-items-center" style="background-color: #f1f1f1">
                <div class="container p-4 mt-5" style="background-color: #f1f1f1">
                    <div class="mb-5">
                        <a href="{{ route('cafeteria') }}" class="text-dark">
                            <ion-icon name="chevron-back-outline" size="large"></ion-icon>
                        </a>
                    </div>
                    <div class="ml-2">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <h1 class="display-4 mb-3 fw-medium">Login</h1>
                            <p class="mb-4">Digite seus dados de acesso abaixo.</p>

                            <div class="form-group">
                                <label for="email">{{ __('Endereço de Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Digite seu e-mail">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Senha') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="Digite sua senha">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group form-check ml-1">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Manter Login') }}</label>
                            </div>

                            <button type="submit" class="btn btn-block mb-3"
                                style="background-color: #35221B; color: #f1f1f1">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <div class="text-left">
                                    <a style="color: #35221B" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu sua Senha?') }}
                                    </a>
                                </div>
                            @endif
                            <div class="text-left">
                                <a style="color: #35221B" href="{{ route('register') }}">
                                    {{ __('Registre-se aqui!') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .login {
        margin: 0;
        padding: 0;
        background-image: url("../images/login.png");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    body {
        overflow: hidden;
    }

    .navbar-brand {
        display: none;
    }
</style>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

@endsection

@php
    $noFooter = true;
@endphp