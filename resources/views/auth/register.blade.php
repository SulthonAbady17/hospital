@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                    </div>
                    <form class="user" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text"
                                class="form-control form-control-user @error('name') is-invalid @enderror"
                                id="name" placeholder="Nama Langkap" name="name" value="{{ old('name') }}"
                                autocomplete="name" autofocus required>
                            @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email"
                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                name="email" id="email" placeholder="Alamat Email" value="{{ old('email') }}"
                                required autocomplete="email">
                            @error('email')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id=" password" placeholder="Password" name="password" required autocomplete="new-password">
                            </div>
                            @error('password')
                            <div class="invalid-feedback row" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user" id="confirm-password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Repeat Password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Register Account
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('password.forgot') }}">Forgot Password?</a>
                    </div>
                    <div class="text-center">
                        <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection