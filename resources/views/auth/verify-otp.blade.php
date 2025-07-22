@extends('layouts.auth')

@section('title', 'Verify OTP')

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
                                    <h1 class="h4 text-gray-900 mb-2">Verifikasi OTP</h1>
                                    <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                        and we'll send you a link to reset your password!</p>
                                </div>
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

                                <p>Kode OTP telah dikirim ke email Anda: <strong>{{ $email ?? session('email') }}</strong>
                                </p>

                                <form class="user" method="POST" action="{{ route('password.verify.otp') }}">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email ?? session('email') }}">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="otp_code"
                                            name="otp_code" required autofocus placeholder="Masukkan OTP..." maxlength="6">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Verifikasi OTP
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.forgot') }}">Kirim Ulang OTP</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
