@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card w-100% ">
                <div class="row justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <!-- ฝั่งซ้าย -->
                                <img src="https://media.discordapp.net/attachments/1068101899712208996/1125310308345458698/20170309-165546295-E0B8AAE0B899E0B8B2E0B8A1E0B881E0B8B5E0B8ACE0B8B2-HOME-9.png"
                                    class="img-fluid" alt="รูปภาพ">
                            </div>
                            <div class="col-md-5 d-flex align-items-center">

                                <div class="row mb-1">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="row mb-3 ms-2 me-2">
                                            <label for="email"
                                                class="col-form-label text-md-start">{{ __('Email Address') }}</label>

                                            <div class="col-md">
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="email" autofocus>

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3 ms-2 me-2">
                                            <label for="password"
                                                class="col-form-label text-md-start">{{ __('Password') }}</label>

                                            <div class="col-md">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3 ms-1">
                                            <div class="form-check ">
                                                <input class="form-check-input ms-2 me-2" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label ms-1" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>

                                        </div>
                                        <div class="ms-2">
                                            <button type="submit" class="btn btn-success ms-3 d-grid gap-2 ">
                                                {{ __('Login') }}
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- <div class="position-relative">
                                <div class="position-absolute bottom-0 end-0">
                                    <div class="col me-5 mb-3">
                                    <a class="text-decoration-none text-dark" href="{{ route('register') }}">
                                        {{ __('register') }}
                                    </a>
                                    |
                                    @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-dark " href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password') }}
                                    </a>
                                    @endif
                                </div>
                            </div> -->
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection
