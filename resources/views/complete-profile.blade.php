@extends('back::layouts.abstract', ['interface' => 'auth'])

@section('content')
    <div class="inner">
        <form method="POST" action="{{ route('register.profile.update') }}">
            @csrf
            @method('patch')
            <p class="pt-2 mb-3 font-bold text-primary">Afin de finaliser votre création de compte, merci de bien
                vouloir définir votre mot de passe (min. 8 caractères) :</p>
            @if (!auth()->user()->firstname)
                <div class="form-group">
                    <label for="firstname">{{ __('validation.attributes.front.first_name') }}</label>
                    <input id="firstname" type="text"
                           class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname"
                           value="{{ old('firstname') }}" required autofocus>
                    @if ($errors->has('firstname'))
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('firstname') }}</strong>
                            </span>
                    @endif
                </div>
            @endif
            @if (!auth()->user()->lastname)
                <div class="form-group">
                    <label for="last_name">{{ __('validation.attributes.front.last_name') }}</label>
                    <input id="last_name" type="text"
                           class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname"
                           value="{{ old('lastname') }}" required autofocus>
                    @if ($errors->has('lastname'))
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lastname') }}</strong>
                            </span>
                    @endif
                </div>
            @endif
            <div class="form-group">
                <label for="password">Saisissez votre mot de passe</label>
                <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                @endif
            </div>
            <div class="form-group mb-4">
                <label for="password-confirm">Confirmez votre mot de passe</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary font-bold px-3">
                    Enregistrer mon mot de passe
                </button>
            </div>
        </form>
    </div>
@endsection
