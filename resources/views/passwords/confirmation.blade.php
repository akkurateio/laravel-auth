@extends('back::layouts.abstract', ['interface' => 'blank'])

@section('content')
    @include('back::atomicdesign.atoms.exit', ['exitRoute' => 'login'])

    <div class="container-fluid">
        <div class="row align-items-center justify-content-center vh-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 text-center">
                <h1>{{ __('Un e-mail a été envoyé') }}</h1>
                <p class="max-w-lg mx-auto">{{ __('Consultez votre messagerie électronique. Nous vous avons envoyé un lien à usage unique pour réinitialiser votre mot de passe.') }}</p>
            </div>
        </div>
    </div>
@endsection
