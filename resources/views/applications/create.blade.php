@extends('layouts.app')

@section('title', 'Pendaftaran Pasien')

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

                    @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('applications.store') }}">
                        @csrf
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="referral_letter" name="referral_letter" required>
                                <label class="custom-file-label" for="referral_letter">Pilih file</label>
                                <small>*.pdf (2MB)</small>
                            </div>
                            @error('referral_letter')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Kirim
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('patient.dashboard') }}">Kembali ke Dashboard Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection