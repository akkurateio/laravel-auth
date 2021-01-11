@extends('back::layouts.abstract', ['interface' => 'auth'])

@section('content')
    <div class="inner">
        <div class="text-3xl font-bold mb-4">{{ __('Connexion') }}</div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group @error('email') has-error @enderror">
                <label for="email">{{ __('Votre adresse email') }}</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                       autocomplete="email" autofocus>
                @include('auth::partials.error', ['error' => 'email'])
            </div>
            <div class="form-group @error('password') has-error @enderror mb-4">
                <label for="password">{{ __('Mot de passe') }}</label>
                <akk-password name="password"></akk-password>
                @include('auth::partials.error', ['error' => 'password'])
            </div>
            <div class="form-group mb-4">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="custom-control-label" for="remember">
                        {{ __('Se souvenir de moi') }}
                    </label>
                </div>
            </div>
            <div class="form-group d-flex flex-column flex-md-row align-items-center align-items-md-center justify-content-md-between">
                <div class="mb-4 mb-md-0">
                    <button type="submit" class="btn btn-primary font-bold px-3">
                        {{ __('Me connecter') }}
                    </button>
                </div>
                @if (Route::has('password.request'))
                    <div>
                        <a class="btn btn-sm btn-link text-2xs"
                           href="{{ route('password.request') }}">
                            {!! __('Mot de passe oublié ?') !!}
                        </a>
                    </div>
                @endif
            </div>
        </form>
        @if(config('laravel-auth.allow_register'))
            <div class="mt-4">
                <div class="text-muted mb-3">ou</div>
                <div class="">
                    <a href="{{ route('register') }}"
                       class="btn btn-outline-primary font-bold px-3">{{ __('M\'inscrire') }}</a>
                </div>
            </div>
        @endif
    </div>
@endsection
