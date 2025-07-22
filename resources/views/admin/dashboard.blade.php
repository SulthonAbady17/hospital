@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah Pengguna <i
                    class="fas fa-fw fa-plus"></i>
            </a>
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php
                                        switch ($user->role) {
                                            case 'patient':
                                                echo 'Pasien';
                                                break;
                                            case 'v1':
                                                echo 'Verifikator 1';
                                                break;
                                            case 'v2':
                                                echo 'Verifikator 2';
                                                break;

                                            default:
                                                echo 'Admin';
                                                break;
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
