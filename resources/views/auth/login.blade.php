@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <login-view inline-template ldap_route="{{ route('api.v1.login.ldap') }}" success_route="{{route('home')}}">
                    <b-card no-body>
                        <b-tabs card content-class="mt-3" align="center" fill>
                            <b-tab title="THM" active>

                                    <h4 class="mb-0">In Ihr THM-Benutzerkonto einloggen</h4>


                                <b-form @submit="onSubmit" @reset="onReset"  >
                                    <b-form-group
                                        id="input-group-ldap-email"
                                        label="THM Benutzerkennung"
                                        label-for="ldap-username"
                                    >
                                        <b-form-input
                                            id="ldap-username"
                                            v-model="form.ldap.username"
                                            type="text"
                                            required
                                            :state="errors.username && errors.username.length > 0 ? false: null"
                                            placeholder="THM Benutzerkennung"
                                        ></b-form-input>

                                        <b-form-invalid-feedback id="input-live-feedback">
                                            <template v-for="error in errors.username">
                                                @{{ error }}
                                            </template>
                                        </b-form-invalid-feedback>
                                    </b-form-group>

                                    <b-form-group id="input-group-ldap-password" label="Passwort" label-for="ldap-password">
                                        <b-form-input
                                            id="ldap-password"
                                            v-model="form.ldap.password"
                                            type="password"
                                            required
                                            :state="errors.password && errors.password.length > 0 ? false: null"
                                            placeholder="Enter name"
                                        ></b-form-input>

                                        <b-form-invalid-feedback id="input-live-feedback">
                                            <template v-for="error in errors.password">
                                                @{{ error }}
                                            </template>
                                        </b-form-invalid-feedback>
                                    </b-form-group>

                                    <b-button type="submit" variant="success">
                                        <b-spinner v-if="loading" small></b-spinner>
                                        Login</b-button>
                                    <b-button type="reset" variant="danger">Reset</b-button>
                                </b-form>
                            </b-tab>
                            <b-tab title="Gäste">
                                <b-card-text>Gäste</b-card-text>
                            </b-tab>
                        </b-tabs>
                    </b-card>

            </login-view>
{{--
            <div class="card">

                <div class="card-body">



                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf
                        @if($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            --}}
        </div>
    </div>
</div>
@endsection
