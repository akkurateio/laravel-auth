@extends('back::layouts.abstract', ['interface' => 'auth'])

@section('content')
    <div class="inner">
        <div class="text-3xl font-bold mb-4">{{ config('laravel-auth.allow_register') ? __('Inscription') : __('Ajouter un utilisateur') }}</div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            @if(class_exists(Akkurate\LaravelAdmin\Models\Account::class))
                <div class="form-group">
                    <label for="account-select">{{ __('Compte') }}</label>
                    <select class="custom-select" name="account_id" id="account-select">
                        <option selected>{{ __('Sélectionner un compte') }}</option>
                        @foreach(\Akkurate\LaravelAdmin\Models\Account::all() as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                    @include('auth::partials.error', ['error' => 'account_id'])
                </div>
            @endif
            @if(Schema::hasColumn('users', 'firstname') && Schema::hasColumn('users', 'lastname'))
                <div class="form-group">
                    <label for="firstname">{{ __('Prénom') }}</label>
                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror"
                           name="firstname" value="{{ old('firstname') }}" autofocus>
                    @include('auth::partials.error', ['error' => 'firstname'])
                </div>
                <div class="form-group">
                    <label for="lastname">{{ __('Nom') }}</label>
                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror"
                           name="lastname" value="{{ old('lastname') }}" autofocus>
                    @include('auth::partials.error', ['error' => 'lastname'])
                </div>
            @else
                <div class="form-group">
                    <label for="name">{{ __('Nom') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" autofocus>
                    @include('auth::partials.error', ['error' => 'name'])
                </div>
            @endif
            <div class="form-group">
                <label for="email">{{ __('Adresse e-mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{ old('email') }}" required>
                @include('auth::partials.error', ['error' => 'email'])
            </div>
            @if(config('laravel-auth.allow_register'))
                <div class="form-group">
                    <label for="password">{{ __('Mot de passe') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required>
                    @include('auth::partials.error', ['error' => 'password'])
                </div>
                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirmation du mot de passe') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required>
                </div>
            @endif
            <div class="form-group akk-mt-4 mb-0 d-flex justify-content-between">
                @if(Route::has('admin'))
                    <a href="{{ route('admin', ['uuid' => request('uuid')]) }}" class="btn btn-outline-secondary">
                        {{ __('Annuler') }}
                    </a>
                @else
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        {{ __('Annuler') }}
                    </a>
                @endif
                <button type="submit" class="btn btn-primary font-bold">
                    {{ __('Enregistrer') }}
                </button>
            </div>
        </form>
    </div>
@endsection
