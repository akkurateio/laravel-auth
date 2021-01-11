@extends('back::layouts.abstract', ['interface' => 'auth'])

@section('content')
    <div class="inner">
        <h2 class="font-bold mb-4">{{ __('Réinitialisation du mot de passe') }}</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">{{ __('Adresse e-mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{ $email ?? old('email') }}" required autofocus>
                @include('auth::partials.error', ['error' => 'email'])
            </div>
            <div class="form-group @error('password') has-error @enderror">
                <label for="password">{{ __('Nouveau mot de passe') }}</label>
                {{--                        <akk-password name="password"></akk-password>--}}
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @include('auth::partials.error', ['error' => 'password'])
            </div>
            <div class="form-group mb-4">
                <label for="password-confirm">{{ __('Confirmation du mot de passe') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                {{--                        <akk-password name="password-confirm" label="Confirmez votre mot de passe"></akk-password>--}}
            </div>
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary font-bold px-3">
                    {{ __('Réinitialiser le mot de passe') }}
                </button>
            </div>
        </form>
    </div>
@endsection
