@extends('back::layouts.abstract', ['interface' => 'auth'])

@section('content')
    <div class="inner">
        <h2 class="font-bold mb-4">{{ __('Réinitialisation du mot de passe') }}</h2>
        <div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group mb-4">
                    <label for="email">{{ __('Saisissez votre email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required>
                    @include('auth::partials.error', ['error' => 'email'])
                </div>

                <div class="form-group mb-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-block btn-primary font-bold">
                        {{ __('Recevoir un lien de réinitialisation') }}
                    </button>
                </div>

                <div class="text-center text-xs">
                    <a href="{{ route('login') }}">
                        {{ __('Annuler') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
