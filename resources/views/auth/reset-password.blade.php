@extends('layouts.auth')

@section('title', 'Reset Password')

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
                                    <h1 class="h4 text-gray-900 mb-2">Atur Ulang Password</h1>
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

                                <p>Mengatur password untuk email:
                                    <strong>{{ $email ?? session('verified_email_for_reset') }}</strong>
                                </p>

                                <form class="user" method="POST" action="{{ route('password.reset') }}">
                                    @csrf
                                    <input type="hidden" name="email"
                                        value="{{ $email ?? session('verified_email_for_reset') }}">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password"
                                            name="password" required autofocus placeholder="Password Baru" minlength="8">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="password_confirmation" name="password_confirmation" required
                                            placeholder="Password Baru">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Atur Ulang Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
