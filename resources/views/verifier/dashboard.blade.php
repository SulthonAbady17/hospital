@extends('layouts.app')

@section('title', 'Verifier Dashboard')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Menampilkan pesan sukses dari sesi flash --}}
            @if (session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif
            {{-- Menampilkan pesan error dari sesi flash --}}
            @if (session('error'))
                <p style="color: red;">{{ session('error') }}</p>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pendaftar</th>
                            <th>Tanggal Pendaftaran</th>
                            <th>Status</th>
                            <th>Surat Rujukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (Auth::user()->role === 'v1')
                            @forelse ($v1_applications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->user->name }}</td>
                                    <td>{{ date('d F Y', strtotime($application->created_at)) }}</td>
                                    <td>
                                        @if ($application->status === 'approved')
                                            <strong style="color: green;">DISETUJUI</strong>
                                        @elseif($application->status === 'rejected')
                                            <strong style="color: red;">DITOLAK</strong>
                                        @else
                                            <strong>Dalam Proses Verifikasi</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($application->referral_letter_path)
                                            <a href="{{ asset('storage/' . $application->referral_letter_path) }}"
                                                target="_blank">Lihat
                                                Surat Rujukan</a>
                                        @else
                                            Tidak ada surat rujukan
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('applications.verify.v1', $application->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                        </form>
                                        <a href="{{ route('applications.reject.form', $application->id) }}"
                                            class="btn btn-danger">
                                            Tolak
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data pendaftaran</td>
                                </tr>
                            @endforelse
                        @else
                            @forelse ($v2_applications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->user->name }}</td>
                                    <td>{{ date('d F Y', strtotime($application->created_at)) }}</td>
                                    <td>
                                        @if ($application->status === 'approved')
                                            <strong style="color: green;">DISETUJUI</strong>
                                        @elseif($application->status === 'rejected')
                                            <strong style="color: red;">DITOLAK</strong>
                                        @else
                                            <strong>Dalam Proses Verifikasi</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($application->referral_letter_path)
                                            <a href="{{ asset('storage/' . $application->referral_letter_path) }}"
                                                target="_blank">Lihat
                                                Surat Rujukan</a>
                                        @else
                                            Tidak ada surat rujukan
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('applications.verify.v1', $application->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                        </form>
                                        <a href="{{ route('applications.reject.form', $application->id) }}"
                                            class="btn btn-danger">
                                            Tolak
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data pendaftaran</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
