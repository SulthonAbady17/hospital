@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                        and we'll send you a link to reset your password!</p>
                                </div>
                                @if (session('status'))
                                    <div>{{ session('status') }}</div>
                                @endif
                                @if (session('success'))
                                    <div style="color: green;">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div style="color: red;">{{ session('error') }}</div>
                                @endif
                                @if ($errors->any())
                                    <div style="color: red;">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="user" method="POST" action="{{ route('password.send.otp') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="email"
                                            name="email" value="{{ old('email') }}" required autofocus
                                            aria-describedby="emailHelp" placeholder="Masukkan alamat email...">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Kirim OTP
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
