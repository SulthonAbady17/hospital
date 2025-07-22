@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="p-5">
                        <div class="">
                            <h1 class="h4 text-gray-900 mb-4">Buat Akun Pengguna/Verifikator Baru</h1>
                        </div>
                        @if (session('success'))
                            <p class="success-message">{{ session('success') }}</p>
                        @endif
                        @if (session('error'))
                            <p class="error-message">{{ session('error') }}</p>
                        @endif
                        @if ($errors->any())
                            <div class="error-message">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="user" method="POST" action="{{ route('admin.users.store') }}">
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
                                    <input type="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        id=" password" placeholder="Password" name="password" required
                                        autocomplete="new-password">
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
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="role">Peran</label>
                                </div>
                                <select class="custom-select" id="role" name="role" required>
                                    <option value="">Pilih Peran</option>
                                    <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Pasien</option>
                                    <option value="v1" {{ old('role') == 'v1' ? 'selected' : '' }}>
                                        Verifikator 1</option>
                                    <option value="v2" {{ old('role') == 'v2' ? 'selected' : '' }}>
                                        Verifikator 2</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Buat Akun
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('admin.dashboard') }}">Kembali ke Dashboard Admin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
