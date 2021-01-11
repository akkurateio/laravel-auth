@extends('back::layouts.abstract', ['interface' => 'auth'])

@section('content')
    <div class="inner">
        @if(config('laravel-auth.allow_register'))
            <h2 class="font-bold mb-4">{{ __('Vérifier votre adresse e-mail') }}</h2>
            <div>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Un nouveau lien a été envoyé sur votre adresse e-mail.') }}
                    </div>
                @endif
                <p>{{ __('Consultez votre messagerie électronique. Nous vous avons envoyé un lien à usage unique pour confirmer votre adresse e-mail.') }}</p>
                {{ __('Si vous n’avez rien reçu')}},
                <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-link p-0 m-0 align-baseline">{{ __('cliquez pour recevoir un nouveau lien') }}</button>
                    .
                </form>
            </div>
        @else
            <h2 class="font-weight-bold akk-mb-4">{{ __('Utilisateur enregistré') }}</h2>
            <div>
                <p>{{ __('Un email a été envoyé à l’utilisateur pour qu’il valide son adresse e-mail et son inscription.') }}</p>
            </div>
            <div class="form-group akk-mt-4 mb-0 d-flex justify-content-between">
                <a href="{{ route('admin', ['uuid' => request('uuid')]) }}" class="btn btn-outline-secondary">
                    {{ __('Retour') }}
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    {{ __('Ajouter un utilisateur') }}
                </a>
            </div>
        @endif
    </div>
@endsection
